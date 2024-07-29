<?php

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\CohortController;
use App\Http\Controllers\TestController;

use App\Http\Controllers\ApplicantController;
use App\Http\Controllers\Round1Controller;
use App\Http\Controllers\Round2Controller;
use App\Http\Controllers\Round3Controller;
use App\Http\Controllers\SurveyController;
use App\Http\Controllers\FollowupSurveyController;
use App\Http\Controllers\OnboardingSurveyController;
use App\Http\Controllers\GoogleFormController;

Route::post('/google-form-response', [GoogleFormController::class,'handleResponse']);

Route::get('/applicant/details/{id}', [ApplicantController::class, 'getApplicantDetails']);


Route::resource('cohorts', CohortController::class);
Route::resource('applicants', ApplicantController::class);
Route::resource('surveys', SurveyController::class);
Route::resource('followupSurvey', FollowupSurveyController::class);
Route::resource('onboardingSurvey', OnboardingSurveyController::class);
Route::resource('round1', Round1Controller::class);
Route::resource('round2', Round2Controller::class);
Route::resource('round3', Round3Controller::class);

// In routes/api.php or routes/web.php
Route::get('round1/getByCohort/{cohortId}', [Round1Controller::class, 'getByCohort']);
Route::get('round2/getByCohort/{cohortId}', [Round2Controller::class, 'getByCohort']);
Route::get('round3/getByCohort/{cohortId}', [Round3Controller::class, 'getByCohort']);
Route::get('followupSurvey/getByCohort/{cohortId}', [FollowupSurveyController::class, 'getByCohort']);
Route::get('onboardingSurvey/getByCohort/{cohortId}', [OnboardingSurveyController::class, 'getByCohort']);



Route::resource('test', TestController::class);



//Route::get('cohorts/index', [CohortController::class, 'index'])->name('cohorts.index');
   Route::post('round1/store', [CohortController::class, 'store']);
Route::post('cohorts/create', [CohortController::class, 'store']);

Route::post('round1/create', [Round1Controller::class, 'store']);
Route::post('surveys/create', [SurveyController::class, 'store']);



//Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
   // return $request->user();
//});
