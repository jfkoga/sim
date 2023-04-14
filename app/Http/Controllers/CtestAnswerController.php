<?php

namespace App\Http\Controllers;

use App\Models\CtestAnswer;
use Illuminate\Http\Request;

class CtestAnswerController extends Controller
{

    private int $idQuestion;
    private int $session_id;
    private int $position;
    private ?string $answers;

    public function __construct($questionId, $myAnswer, $lastId, $page) {
        $this->idQuestion = $questionId;
        $this->session_id = $lastId;
        $this->position = $page;
        $this->answers = $myAnswer;
    }

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
        if (CtestAnswer::where('idQuestion', $this->idQuestion)->where('session_id', $this->session_id)->exists()) {
            $ctestAnswer = CtestAnswer::where('idQuestion', $this->idQuestion)->where('session_id', $this->session_id)->first();
        }else{
            $ctestAnswer = new CtestAnswer();
            $ctestAnswer->idQuestion = $this->idQuestion;
            $ctestAnswer->session_id = $this->session_id;
        }
        $ctestAnswer->position = $this->position;
        $ctestAnswer->answers = $this->answers;
        $ctestAnswer->save();

        return redirect()->back();
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
}
