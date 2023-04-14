<?php

namespace App\Http\Controllers;

use App\Models\Session;
use App\Models\CtestAnswer;
use App\Http\Controllers\CtestAnswerController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CtestController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class SessionController extends Controller
{
    private const CTEST_STEP = 'ctest.step';

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $session = new Session();
        $session->user_id = Auth::user()->id;
        $session->language = app()->getLocale();
        $session->position = 0;
        $session->save();
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function beginSession(Request $request, string $email)
    {

        $user = (new UserController)->handleSessionStart($email);

        if (count($user->sessions)  > 0) {
            $x = $user->sessions->last();

            $diference = $x->created_at->diffInDays(Carbon::now());

            // Si no han pasado 30 días desde la última sesión no podrá continuar
            if ($diference < 30) {
                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();
                return redirect()->route('welcome')->with('30daysLimit', 'Hace menos de 30 dias que hiciste una evaluación, no puedo dejarte pasar.');
            } else {
                $this->store($request);
                $position = 1;
            }
        } else {
            $this->store($request);
            $position = 1;
        }
        return redirect()->route(self::CTEST_STEP, encrypt($position));
    }

    public function redirect(Request $request, int $page, int $questionId, string $myAnswer)
    {
        $action = $request->input('action');
        $timer = $request->session()->get('examDuration');
        $now = Carbon::now()->format('M d, Y H:i:s');

        if (Session::where('user_id', Auth::user()->id)->exists()) {
            $session = Session::where('user_id', Auth::user()->id)->orderBy('created_at', 'DESC')->first();
        } else {
            $session = new Session();
            $session->user_id = Auth::user()->id;
            $session->language = app()->getLocale();
        }
        $session->position = $page;
        $session->save();
        $lastId = $session->id;

        $answer_controller = new CtestAnswerController($questionId, $myAnswer, $lastId, $page);
        $answer_controller->store($request);

        // Si se agota el tiempo...
        if ($now > $timer) {
            echo 'Redirigir a MCQ con lo que tengas <br><hr>';
            (new CtestController)->checkAnswers($request);
        }

        if ($action === 'next') {
            $q = $session->position + 1;
            $dbQuestion = CtestAnswer::where(['position' => $q, 'session_id' => $session->id])
                ->orderBy('id', 'DESC')
                ->first();
            $request->session()->put('dbQuestion', $dbQuestion);
            if ($page == 1 || $page == 2 || $page == 3) {
                return redirect()->route(self::CTEST_STEP, encrypt($page+1))->send();
            }elseif($page == 4){
                return redirect()->route('ctest.checkAnswers')->send();
            }
        } else if ($action === 'back') {
            $q = $session->position - 1;
            $dbQuestion = CtestAnswer::where(['position' => $q, 'session_id' => $session->id])
                ->orderBy('id', 'DESC')
                ->first();
            $request->session()->put('dbQuestion', $dbQuestion);
            return redirect()->route(self::CTEST_STEP, encrypt($q))->send();
        }
    }


}
