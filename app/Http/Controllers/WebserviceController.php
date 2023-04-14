<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Session;
use App\Models\CtestResult;
use App\Models\MCQResult;

class WebserviceController extends Controller
{
    public function getLastGrade(Request $request, string $email)
    {
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $user = User::where('email', $email)->first();
            if ($user != null) {
                $lastSession = Session::where('user_id', $user->id)->orderBy('created_at', 'desc')->first();

                $ctest = CtestResult::where('session_id', $lastSession->id)
                    ->orderBy('created_at', 'desc')
                    ->get(['ctest_points', 'ctest_level', 'created_at'])
                    ->first();

                $mcq = MCQResult::where('session_id', $lastSession->id)
                    ->orderBy('created_at', 'desc')
                    ->get(['henning_level', 'mcq_level', 'created_at'])
                    ->first();

            }else{
                return 'User not found';
            }
        }else{
            return 'Wrong email format';
        }
        return compact('email', 'ctest', 'mcq');
    }
}
