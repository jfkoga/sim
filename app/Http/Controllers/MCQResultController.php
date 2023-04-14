<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MCQResult;

class MCQResultController extends Controller
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
    public function store(Request $request, int $sessionId, int $henningLvl, float $ability)
    {
        $mcqResult = new MCQResult();
        $mcqResult->session_id = $sessionId;
        $mcqResult->henning_level = $henningLvl;
        $mcqResult->mcq_level = $ability;
        $mcqResult->save();
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
