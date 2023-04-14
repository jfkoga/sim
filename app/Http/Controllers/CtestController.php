<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ctest;
use App\Models\CtestAnswer;
use App\Models\Session;
use App\Http\Controllers\SessionController;
use App\Http\Controllers\CtestResultController;
use Carbon\Carbon;
use DOMDocument;
use Illuminate\Support\Facades\Auth;

class CtestController extends Controller
{
    /**
     * Gestiona a que vista debe ir.
     * @param showView [1..4] El punto del exámen o la vista que se desea mostrar
     */
    public function step(Request $request, string $showView)
    {
        $showView = decrypt($showView);
        // Obtengo datos guardados en sesión local
        $timer = $request->session()->get('examDuration');
        $dbQuestion = $request->session()->get('dbQuestion');
        $sessionQuestion = $request->session()->get('sessionQuestion');
        $arrayQuestions = $request->session()->get('arrayOfQs');

        $now = Carbon::now()->format('M d, Y H:i:s');

        // Compruebo si existe la sesión del tiempo del test
        $timer = $this->checkTimer($request, $now, $timer);

        if (isset($dbQuestion)) {
            echo 'Recibido por parametro';
            $question = Ctest::find($dbQuestion->idQuestion);
        } else {
            if (isset($sessionQuestion)) {
                echo 'Existe la pregunta random guardada en sesión<br>';
                $question = Ctest::find($sessionQuestion);
            } else {
                if ($arrayQuestions) {
                    // Pregunta aleatoria excepto las IDs que se encuentren en el array
                    echo 'Random excepto: ';
                    $question = Ctest::inRandomOrder()->whereNotIn('id', $arrayQuestions)->get()->first();
                    $this->storeQarraySession($request, $question->id, $arrayQuestions);
                } else {
                    // Pregunta completamente aleatoria
                    echo 'Completamente random / ';
                    $question = Ctest::inRandomOrder()->first();
                    $this->storeQarraySession($request, $question->id);
                }
            }
        }

        $storedAnswer = CtestAnswer::where('idQuestion', $question->id)->get('answers')->first();

        $phpDOM = ($storedAnswer != null) ? $this->fillableInputs($question, $storedAnswer) : $question->ctest;

        return view('ctest.ctest' . $showView, compact('question', 'timer', 'phpDOM'));
    }


    public function progress(Request $request, string $currentPage, string $questionId)
    {
        if ($request->session()->has('sessionQuestion')) {
            $request->session()->forget('sessionQuestion');
        }

        $currentPage = decrypt($currentPage);
        $questionId = decrypt($questionId);

        $array = $request->input();
        unset($array['_token'], $array['action']);

        $myAnswer = json_encode($array);

        $session_controller = new SessionController();
        return $session_controller->redirect($request, $currentPage, $questionId, $myAnswer);
    }


    public function storeQarraySession(Request $request, int $qId, $arrayQuestions = [])
    {
        var_dump($arrayQuestions);
        array_push($arrayQuestions, $qId);
        $request->session()->put('arrayOfQs', $arrayQuestions);
        $request->session()->put('sessionQuestion', $qId);
    }


    public function fillableInputs(Ctest $q, CtestAnswer $storedAnswer)
    {
            echo '<br>';
            echo 'Respuesta/s existentes en BD';
            $result = array_values(json_decode($storedAnswer->answers, true));

            $dom = new DOMDocument();
            $dom->loadHTML(mb_convert_encoding($q->ctest, 'HTML-ENTITIES', "UTF-8"));
            $nodeList = $dom->getElementsByTagName('input');

            $i = 0;
            foreach ($nodeList as $node) {
                $node->setAttribute('value', $result[$i]);
                $i++;
            }

        return $dom->saveHTML();
    }


    public function checkAnswers(Request $request)
    {
        $correct = $wrong = 0;

        $answers = CtestAnswer::orderBy('created_at', 'desc')->limit(4)->get();

        foreach ($answers as $answer) {
            // Respuestas del usuario guardadas en BD
            $arrayAnswers = array_values(json_decode($answer->answers, true));
            // Pregunta que se ha respondido
            $currentQuestion = Ctest::find($answer->idQuestion);
            // Array de las respuestas oficiales
            $expectedAnswer = explode("~", $currentQuestion->answers);
            //Elimino la ultima posicion del array, ya que debido al caracter final de las respuestas (~) se crea un elemento extra vacío
            unset($expectedAnswer[count($expectedAnswer)-1]);

            $newDom = new DOMDocument();
            $newDom->loadHTML(mb_convert_encoding($currentQuestion->ctest, 'HTML-ENTITIES', "UTF-8"));
            $nodeList = $newDom->getElementsByTagName('span');

            for ($i=0; $i < count($nodeList); $i++) {
                // Si no se ha respondido la variable es NULL, de ser así se convierte en string vacío
                $arrayAnswers[$i] = ($arrayAnswers[$i] != null) ? $arrayAnswers[$i] : '';

                // Concateno la palabra del span con el input del usuario
                $word = $nodeList[$i]->textContent . $arrayAnswers[$i];

                // Contando respuestas correctas y erróneas
                list($correct, $wrong) = $this->compareStrings($word, $expectedAnswer[$i], $correct, $wrong);
            }
            echo '-----------<br><br>';
        }
        $ctestLevel = $this->ctestPunctuation($correct);

        (new CtestResultController)->store($request, $correct, $ctestLevel);
    }


    public function compareStrings(string $answer, string $expectedAnswer, int $correct, int $wrong)
    {
        if ($answer == $expectedAnswer) {
            $correct++;
            $checker = 'V';
        }else{
            $wrong++;
            $checker = 'X';
        }

        echo 'Does <b>' . $answer . '</b> look like: <b>' . $expectedAnswer . '</b>? [' . $checker . ']';
        echo '<br>';
        return array($correct, $wrong);
    }


    public function ctestPunctuation(int $mark)
    {
        switch (true) {
            case $mark > 99:
                $lvl = 5;
                break;

            case $mark > 80.5:
                $lvl = 4;
                break;

            case $mark > 76.5:
                $lvl = 3;
                break;

            case $mark > 67.5:
                $lvl = 2;
                break;

            case $mark < 67.5:
                $lvl = 1;
                break;

            default:
                $lvl = 1;
                break;
        }
        return $lvl;
    }


    public function checkTimer(Request $request, string $now, string $timer = null){
        if (!$timer){
            $timer = Carbon::now()->addMinutes(2.5)->format('M d, Y H:i:s');
            $request->session()->put('examDuration', $timer);
        }else{
            echo 'Exámen disponible hasta: ' . $timer . '<br>';

            // Compruebo que no se haya superado el tiempo disponible para el test
            if ($now > $timer) {
                // Caducar session y redirigir
                $currentSession = Auth::user()->sessions->last();
                $request->session()->flush();
                if ($currentSession != null) {
                    $currentSession->delete();
                }
                $this->checkAnswers($request);
            }
        }
        return $timer;
    }

}
