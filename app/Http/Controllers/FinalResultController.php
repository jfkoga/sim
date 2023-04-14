<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Classes\FinalGrade;
use Illuminate\Support\Facades\Auth;
use App\Models\CtestResult;
use App\Models\MCQResult;

class FinalResultController extends Controller
{
    public function getGrades(Request $request){
        $user = Auth::user();
        $userSession = $user->sessions->last();

        $grade = new FinalGrade();
        $grade->loadSessionResults($userSession->id);
        $finalGrade = $grade->calculateFinalGrade();
        $conversion = $grade->convertGrade($finalGrade);
        return array($finalGrade, $conversion);
    }

}
