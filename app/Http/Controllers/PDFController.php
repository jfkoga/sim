<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\User;
use App\Models\CtestResult;
use App\Models\MCQResult;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;

class PDFController extends Controller
{
    public function finalScreen(string $grade, string $val){
        $user = Auth::user();
        $grade = decrypt($grade);
        $val = decrypt($val);

        return view('finalScreen', compact('user', 'grade', 'val'));
    }

    public function generatePDF(Request $request, string $conversion){
        $carbon = Carbon::now();
        $now = $carbon->format('d/m/Y - H:i');
        $conversion = decrypt($conversion);
        $documentName = 'simtest_' . $carbon->format('dmyHi') . '.pdf';

        if (Auth::user() != null) {
            $auth = Auth::user();
        }else{
            abort(403);
        }

        $data = [
            'title' => 'SIMTEST Results',
            'timestamp' => $now,
            'user' => $auth,
            'qualification' => $conversion
        ];

        $dompdf = App::make('dompdf.wrapper');

        // Metadata
        $dompdf->add_info('Title', 'Simtest Results');
        $dompdf->add_info('Author', 'IThink UPC Dev Team');
        $dompdf->add_info('Subject', 'CTest + MCQ result');
        $dompdf->add_info('Creator', 'IThink UPC');

        // Ruta de la vista HTML a cargar y los datos que contendra la vista
        $dompdf->loadView('pdf.test', compact('data'));
        $dompdf->render();

        // Automatically download
        return $dompdf->download($documentName);
    }

}
