<?php

namespace App\Listeners;

use App\Events\SurveyReminderNeeded;
use App\Mail\SurveyReminder;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SendSurveyReminder
{
    /**
     * Handle the event.
     *
     * @return void
     */
    public function handle(SurveyReminderNeeded $event)
    {
        Log::info('Handling SurveyReminderNeeded event.');

        $survey = $event->survey;
        $applicant = $event->applicant;

        if ($applicant) {
            Log::info('Sending email to: '.$applicant->email);

            Mail::to($applicant->email)->send(new SurveyReminder($survey, $applicant));
        } else {
            Log::warning('No applicant found for survey ID: '.$survey->id);
        }
    }
}
