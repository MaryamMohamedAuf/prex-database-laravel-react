<?php
namespace App\Mail;
use Illuminate\Support\Facades\Log;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Models\Applicant;
use App\Models\Survey;

class SurveyReminder extends Mailable
{
    use Queueable;
    //, SerializesModels;

    public $applicant;
    public $survey;

    public function __construct(Survey $survey, Applicant $applicant)
    {
        $this->applicant = $applicant;
       $this->survey = $survey;
    }

    public function build()
    {
        Log::info('Building survey reminder email for applicant: ' . $this->applicant->email);

        return $this->subject('Reminder: Follow-Up Survey Due')
                    ->view('survey_reminder') 
                    ->with([
                        'applicant' => $this->applicant,
                    ]);
    }
}
