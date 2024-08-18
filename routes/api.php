<?php

use App\Http\Controllers\ApplicantController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\CohortController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\FollowupSurveyController;
use App\Http\Controllers\GoogleFormController;
use App\Http\Controllers\OnboardingSurveyController;
use App\Http\Controllers\Round1Controller;
use App\Http\Controllers\Round2Controller;
use App\Http\Controllers\Round3Controller;
use App\Http\Controllers\SurveyController;
use Illuminate\Support\Facades\Route;


Route::get('/cohorts/index', [CohortController::class, 'index'])->name('cohorts.index');
Route::post('/register', [RegisteredUserController::class, 'store'])->middleware('guest')->name('register');

Route::post('/login', [AuthenticatedSessionController::class, 'store']);
Route::post('round1/create', [Round1Controller::class, 'store']);
Route::post('round2/create', [Round2Controller::class, 'store']);
Route::post('followupSurvey/create', [FollowupSurveyController::class, 'store']);
Route::post('onboardingSurvey/create', [OnboardingSurveyController::class, 'store']);

Route::middleware('auth:sanctum')->group(function () {
    Route::put('/admin/edit/{id}', [RegisteredUserController::class, 'update']);
    Route::get('/admin/{id}', [RegisteredUserController::class, 'show']);
    Route::get('/admins', [RegisteredUserController::class, 'index']);
    Route::delete('/admin/{id}', [RegisteredUserController::class, 'destroy']);

    Route::put('round1/{id}', [Round1Controller::class, 'update']);
    Route::get('round1/{id}', [Round1Controller::class, 'show']);
    Route::delete('round1/{id}', [Round1Controller::class, 'destroy']);

    Route::put('/round2/{id}', [Round2Controller::class, 'update']);
    Route::get('round2/{id}', [Round2Controller::class, 'show']);
    Route::delete('round2/{id}', [Round2Controller::class, 'destroy']);

    Route::put('followupSurvey/{id}', [FollowupSurveyController::class, 'update']);
    Route::get('followupSurvey/{id}', [FollowupSurveyController::class, 'show']);
    Route::delete('followupSurvey/{id}', [FollowupSurveyController::class, 'destroy']);
    Route::get('followupSurvey', [FollowupSurveyController::class, 'index']);


    Route::put('onboardingSurvey/{id}', [OnboardingSurveyController::class, 'update']);
    Route::get('onboardingSurvey/{id}', [OnboardingSurveyController::class, 'show']);
    Route::get('onboardingSurvey', [OnboardingSurveyController::class, 'index']);

    Route::delete('onboardingSurvey/{id}', [OnboardingSurveyController::class, 'destroy']);

    Route::put('onboardingSurvey/{id}', [OnboardingSurveyController::class, 'update']);
    Route::get('onboardingSurvey/{id}', [OnboardingSurveyController::class, 'show']);
    Route::delete('onboardingSurvey/{id}', [OnboardingSurveyController::class, 'destroy']);

    Route::resource('cohorts', CohortController::class);
    Route::resource('comments', CommentController::class);

    Route::resource('applicants', ApplicantController::class);
    Route::resource('surveys', SurveyController::class);
    Route::resource('round3', Round3Controller::class);

    Route::get('round1/getByCohort/{cohortId}', [Round1Controller::class, 'getByCohort']);
    Route::get('round2/getByCohort/{cohortId}', [Round2Controller::class, 'getByCohort']);
    Route::get('round3/getByCohort/{cohortId}', [Round3Controller::class, 'getByCohort']);
    Route::get('followupSurvey/getByCohort/{cohortId}', [FollowupSurveyController::class, 'getByCohort']);
    Route::get('onboardingSurvey/getByCohort/{cohortId}', [OnboardingSurveyController::class, 'getByCohort']);

    Route::get('/applicant/details/{id}', [ApplicantController::class, 'show']);

    Route::post('/comments/{applicant_id}/{round_id}/{round_type}', [CommentController::class, 'store']);

    Route::get('/comments/applicant/{id}', [CommentController::class, 'getCommentsByApplicant']);
    Route::post('/applicants/filter', [ApplicantController::class, 'filter']);
    Route::get('/filter-options', [ApplicantController::class, 'getFilterOptions']);


});
//Route::post('/google-form-response', [GoogleFormController::class,'handleResponse']);
