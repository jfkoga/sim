<?php

namespace App\Http\Controllers;

use App\Classes\HenningAlgorithm;
use App\Models\MCQ;
use App\Models\HenningAlgorithmData;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MCQController extends Controller
{
    /**
     * Busco una pregunta aleatoria con ese nivel de dificultad
     */
    public function step(Request $request, string $level)
    {
        $level = decrypt($level);
        $MCQsession = $request->session()->get('MCQsession');
        $arrayQuestions = $request->session()->get('arrayOfMCQs');

        if ($MCQsession) {
            echo 'Existe la pregunta random guardada en sesión<br>';
            $myMCQ = MCQ::find($MCQsession);
        } elseif ($arrayQuestions) {
            echo 'Random excepto: ';
            $myMCQ = MCQ::where('level', $level)->inRandomOrder()->whereNotIn('id', $arrayQuestions)->first();
            $this->storeArraySession($request, $myMCQ->id, $arrayQuestions);
        } else {
            echo 'Completamente random / ';
            $myMCQ = MCQ::where('level', $level)->inRandomOrder()->get()->first();
            $this->storeArraySession($request, $myMCQ->id);
        }

        return view('mcq.mcq', compact('myMCQ'));
    }


    public function progress(Request $request, string $questionId)
    {
        $questionId = decrypt($questionId);

        $validated = $request->validate([
            'q' => 'required',
        ]);

        if ($validated && $request->session()->has('MCQsession')) {
            $request->session()->forget('MCQsession');
        }
        $mcq = MCQ::where('id', $questionId)->first();

        // Guardar respuesta, redirigir a la siguiente pregunta
        (new MCQAnswerController)->store($request, $questionId, $validated['q']);

        $this->compareAnswer($request, $validated['q'], $mcq->SOL, $mcq->level);

    }


    public function compareAnswer(Request $request, string $input, string $expectedAns, int $level)
    {
        $sequenceIteration = $request->session()->get('sequenceIteration');

        if ($sequenceIteration) {
            $sequenceIteration++;
        } else {
            $sequenceIteration = 1;
        }

        $isCorrect = $input === $expectedAns;

        $userSession = Auth::user()->sessions->last();

        // Contador usando el modelo (ORM)
        $count = HenningAlgorithmData::where('session_id', $userSession->id)
            ->get()
            ->count();

        // Instancia de la clase
        $henning = new HenningAlgorithm();

        if ($count !== 0) {
            $iteration = HenningAlgorithmData::where('session_id', $userSession->id)
                ->orderBy('id', 'desc')
                ->first();

            $henning->setVariable('difficultyHigh', [$iteration->difficulty_high_high, $iteration->difficulty_high_low]);
            $henning->setVariable('difficultyLow', [$iteration->difficulty_low_high, $iteration->difficulty_low_low]);
            $henning->setVariable('currentDifficulty', $iteration->current_difficulty);
            $henning->setVariable('nextDifficulty', $iteration->next_difficulty);
            $henning->setVariable('sumDifficulty', $iteration->sum_difficulty);
            $henning->setVariable('length', $iteration->length);
            $henning->setVariable('numRight', $iteration->num_right);
            $henning->setVariable('width', $iteration->width);
            $henning->setVariable('proportion', $iteration->proportion);
            $henning->setVariable('A', $iteration->A);
            $henning->setVariable('B', $iteration->B);
            $henning->setVariable('C', $iteration->C);
            $henning->setVariable('ability', $iteration->ability);
            $henning->setVariable('error', $iteration->error);
        } else {
            // First iteration.
            $henning->fillFirstIteration($level, $isCorrect);
        }

        if ($henning->iteration($isCorrect)) {
            (new MCQResultController)->store(
                $request,
                $userSession->id,
                $henning->getVariable('nextDifficulty'), 
                $henning->getVariable('ability')
            );
            $request->session()->forget(['arrayOfQs', 'dbQuestion']);
            $request->session()->forget('sequenceIteration');
            [$mark, $converted] = (new FinalResultController)->getGrades($request);
            return redirect()->route('finalScreen', [encrypt($mark), encrypt($converted)])->send();
        }

        $myHenning = new HenningAlgorithmData();
        $myHenning->session_id = $userSession->id;
        $myHenning->question_sequence = $sequenceIteration;
        $myHenning->difficulty_high_high = $henning->getVariable('difficultyHigh')[0];
        $myHenning->difficulty_high_low = $henning->getVariable('difficultyHigh')[1];
        $myHenning->difficulty_low_high = $henning->getVariable('difficultyLow')[0];
        $myHenning->difficulty_low_low = $henning->getVariable('difficultyLow')[1];
        $myHenning->current_difficulty = $henning->getVariable('currentDifficulty');
        $myHenning->next_difficulty = $henning->getVariable('nextDifficulty');
        $myHenning->sum_difficulty = $henning->getVariable('sumDifficulty');
        $myHenning->length = $henning->getVariable('length');
        $myHenning->num_right = $henning->getVariable('numRight');
        $myHenning->width = $henning->getVariable('width');
        $myHenning->proportion = $henning->getVariable('proportion');
        $myHenning->A = $henning->getVariable('A');
        $myHenning->B = $henning->getVariable('B');
        $myHenning->C = $henning->getVariable('C');
        $myHenning->ability = $henning->getVariable('ability');
        $myHenning->error = $henning->getVariable('error');

        $myHenning->save();

        unset($myHenning);

        $nextScreenLvl = $henning->getVariable('nextDifficulty');

        $request->session()->put('sequenceIteration', $sequenceIteration);

        return redirect()->route('mcq.step', encrypt($nextScreenLvl))->send();
    }


    public function storeArraySession(Request $request, int $id, $arrayQuestions = []): void {
        var_dump($arrayQuestions);
        $arrayQuestions[] = $id;
        $request->session()->put('arrayOfMCQs', $arrayQuestions);
        $request->session()->put('MCQsession', $id);
    }

}
