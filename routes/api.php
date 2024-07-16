<?php

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\CohortController;
use App\Http\Controllers\ApplicantController;
use App\Http\Controllers\Round1Controller;
use App\Http\Controllers\Round2Controller;
use App\Http\Controllers\Round3Controller;
use App\Http\Controllers\SurveyController;
use App\Http\Controllers\FollowupSurveyController;
use App\Http\Controllers\OnboardingSurveyController;
use App\Http\Controllers\GoogleFormController;


Route::post('/google-form-response', [GoogleFormController::class,'handleResponse']);


Route::resource('cohorts', CohortController::class);
Route::resource('applicants', ApplicantController::class);
Route::resource('surveys', SurveyController::class);
Route::resource('followupSurvey', FollowupSurveyController::class);
Route::resource('onboardingSurvey', OnboardingSurveyController::class);
Route::resource('round1', Round1Controller::class);
Route::resource('round2', Round2Controller::class);
Route::resource('round3', Round3Controller::class);


Route::get('cohorts/index', [CohortController::class, 'index'])->name('cohorts.index');
Route::post('cohorts/create', [CohortController::class, 'store']);
Route::post('cohorts/create', [CohortController::class, 'store']);
Route::post('cohorts/create', [CohortController::class, 'store']);

Route::post('round1/create', [Round1Controller::class, 'store']);
Route::post('surveys/create', [SurveyController::class, 'store']);



//Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
   // return $request->user();
//});
