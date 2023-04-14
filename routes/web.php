<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\TutorialController;
use App\Http\Controllers\CtestController;
use App\Http\Controllers\MCQController;
use App\Http\Controllers\SessionController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CtestAnswerController;
use App\Http\Controllers\PDFController;
use App\Http\Controllers\CtestResultController;
use App\Http\Controllers\MCQResultController;
use App\Http\Controllers\WebserviceController;

use App\Http\Middleware\RequiredURLparameter;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
})->name('welcome');


Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');


// Language switcher
Route::get('language/{locale}', function ($locale) {
    app()->setLocale($locale);
    session()->put('locale', $locale);
    return redirect()->back();
});


// Tutorial screens
Route::view('/tutorial', 'tutorial.language')->name('tutorialLang');
Route::middleware(RequiredURLparameter::class)->group(function () {
    Route::get('/tutorial1', [TutorialController::class, 'ctest_tutorialOne'])->name('tutorial1');
    Route::get('/tutorial2', [TutorialController::class, 'ctest_tutorialTwo'])->name('tutorial2');
});
Route::get('/mcqTutorial/{level}', [TutorialController::class, 'mcqTutorial'])->name('mcqIntro')->middleware('auth');


// C-Test
Route::get('/ctest/create-step/{view}', [CtestController::class, 'step'])->name('ctest.step')->middleware('auth');
Route::post('/ctest/{currentPage}/{questionId}', [CtestController::class, 'progress'])->name('ctest.progress')->middleware('auth');
Route::get('/ctest/checking', [CtestController::class, 'checkAnswers'])->name('ctest.checkAnswers')->middleware('auth');


// CtestAnswer
Route::resource('answer', CtestAnswerController::class);


// CtestResult
Route::resource('CtestResult', CtestResultController::class);


// Session
Route::resource('/session', SessionController::class)->middleware('auth');
Route::get('/startSession/{email}', [SessionController::class, 'beginSession'])->name('beginSession');


// MCQ
Route::get('/mcq/mcq-step/{level}', [MCQController::class, 'step'])->name('mcq.step')->middleware('auth');
Route::post('/mcq/{questionId}', [MCQController::class, 'progress'])->name('mcq.progress')->middleware('auth');


// MCQResult
Route::resource('CtestResult', MCQResultController::class);


// Final Screen & PDF
Route::get('/finalScreen/{level}/{conv}', [PDFController::class, 'finalScreen'])->name('finalScreen');
Route::get('generatePDF/{conversion}', [PDFController::class, 'generatePDF'])->name('myPDF');


// Webservice
Route::get('/webservice/{email}', [WebserviceController::class, 'getLastGrade'])->name('webservice');

require __DIR__ . '/auth.php';
