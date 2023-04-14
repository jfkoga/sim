<?php

namespace App\Http\Controllers;

use App\Models\MCQAnswer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MCQAnswerController extends Controller
{
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
    public function store(Request $request, int $questionId, string $validatedAnswer)
    {
        $mcq = new MCQAnswer();
        $mcq->idQuestion = $questionId;
        $mcq->idSession = Auth::user()->sessions->last()->id;
        $mcq->answer = $validatedAnswer;
        $mcq->save();

        return back();
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
