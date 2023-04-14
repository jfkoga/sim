<?php

namespace App\Http\Controllers;

use App\Models\CtestResult;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CtestResultController extends Controller
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
    public function store(Request $request, int $correctAnswers, int $ctestLevel)
    {
        $currentSession = Auth::user()->sessions->last();
        $ctestResult = new CtestResult();
        $ctestResult->session_id = $currentSession->id;
        $ctestResult->ctest_points = $correctAnswers;
        $ctestResult->ctest_level = $ctestLevel;

        $ctestResult->save();

        return redirect()->route('mcqIntro', $ctestLevel)->send();
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
