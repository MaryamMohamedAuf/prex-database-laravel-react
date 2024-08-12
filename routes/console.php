<?php
use App\Http\Controllers\FollowupSurveyController;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schedule;
use App\Mail\SurveyReminder;
use Illuminate\Support\Facades\Mail;

// Schedule::call(function () {
//        (new FollowupSurveyController())->handle();
//      })->daily();


Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();
