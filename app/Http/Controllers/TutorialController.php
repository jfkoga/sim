<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class TutorialController extends Controller
{
    /**
     * Displays C-Test tutorial before test (1/2).
     *
     */
    public function ctest_tutorialOne(Request $request){
        Cache::flush();
        $user = $request->input('user');
        return view('tutorial.tutorial1', compact('user'));
    }

    /**
     * Displays C-Test tutorial before test (2/2).
     *
     */
    public function ctest_tutorialTwo(Request $request){
        Cache::flush();
        $user = $request->input('user');
        return view('tutorial.tutorial2', compact('user'));
    }

    /**
     * Displays MCQ tutorial mid test.
     *
     */
    public function mcqTutorial(Request $request, int $level){
        return view('mcq.instructions', compact('level'));
    }

}
