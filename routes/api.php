<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\CohortController;
use App\Http\Controllers\ApplicantController;
use App\Http\Controllers\Round1Controller;
use App\Http\Controllers\Round2Controller;
use App\Http\Controllers\Round3Controller;
use App\Http\Controllers\SurveyController;
use App\Http\Controllers\FollowupSurveyController;
use App\Http\Controllers\OnboardingSurveyController;
use App\Http\Controllers\GoogleFormController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;

Route::post('/register', [RegisteredUserController::class, 'store']) ->middleware('guest')->name('register');
Route::post('/login', [AuthenticatedSessionController::class, 'store']);
Route::post('round1/create', [Round1Controller::class, 'store']);
Route::post('round2/create', [Round2Controller::class, 'store']);
Route::post('followupSurvey/create', [FollowupSurveyController::class, 'store']);
Route::post('onboardingSurvey/create', [OnboardingSurveyController::class, 'store']);

Route::middleware('auth:sanctum')->group(function () {
    
         Route::put('round1/{id}', [Round1Controller::class, 'update']);
         Route::get('round1/{id}', [Round1Controller::class, 'show']);
         Route::delete('round1/{id}', [Round1Controller::class, 'destroy']);
         
         Route::put('round2/{id}', [Round2Controller::class, 'update']);
         Route::get('round2/{id}', [Round2Controller::class, 'show']);
         Route::delete('round2/{id}', [Round2Controller::class, 'destroy']);

         Route::put('followupSurvey/{id}', [FollowupSurveyController::class, 'update']);
         Route::get('followupSurvey/{id}', [FollowupSurveyController::class, 'show']);
         Route::delete('followupSurvey/{id}', [FollowupSurveyController::class, 'destroy']);

         Route::put('onboardingSurvey/{id}', [OnboardingSurveyController::class, 'update']);
         Route::get('onboardingSurvey/{id}', [OnboardingSurveyController::class, 'show']);
         Route::delete('onboardingSurvey/{id}', [OnboardingSurveyController::class, 'destroy']);

         Route::put('onboardingSurvey/{id}', [OnboardingSurveyController::class, 'update']);
         Route::get('onboardingSurvey/{id}', [OnboardingSurveyController::class, 'show']);
         Route::delete('onboardingSurvey/{id}', [OnboardingSurveyController::class, 'destroy']);

Route::resource('cohorts', CohortController::class);
Route::resource('comments', CommentController::class);

Route::resource('applicants', ApplicantController::class);
Route::resource('surveys', SurveyController::class);
//Route::resource('followupSurvey', FollowupSurveyController::class);
//Route::resource('onboardingSurvey', OnboardingSurveyController::class);
Route::resource('round3', Round3Controller::class);
Route::get('round1/getByCohort/{cohortId}', [Round1Controller::class, 'getByCohort']);
Route::get('round2/getByCohort/{cohortId}', [Round2Controller::class, 'getByCohort']);
Route::get('round3/getByCohort/{cohortId}', [Round3Controller::class, 'getByCohort']);
Route::get('followupSurvey/getByCohort/{cohortId}', [FollowupSurveyController::class, 'getByCohort']);
Route::get('onboardingSurvey/getByCohort/{cohortId}', [OnboardingSurveyController::class, 'getByCohort']);
Route::get('/applicant/details/{id}', [ApplicantController::class, 'getApplicantDetails']);
Route::get('/comments/applicant/{id}', [CommentController::class, 'getCommentsByApplicant']);
// Route::post('/comments/{applicant_id}/{round1_id?}/{round2_id?}/{round3_id?}', [CommentController::class, 'store']);
Route::post('/comments/{applicant_id}/{round_id}/{round_type}', [CommentController::class, 'store']);


});

//Route::post('/google-form-response', [GoogleFormController::class,'handleResponse']);
?>
