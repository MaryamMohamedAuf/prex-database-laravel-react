<?php

namespace App\Console\Commands;

use App\Services\FollowupSurveyService;
use Illuminate\Console\Command;

class SendSurveyReminders extends Command
{
    protected $signature = 'survey:send-reminders';

    protected $description = 'Send reminders for follow-up surveys';

    protected $followupSurveyService;

    public function __construct(FollowupSurveyService $followupSurveyService)
    {
        //By calling the parent constructor, you ensure that the child class (SendSurveyReminders) can build upon or extend the functionality provided by the parent class (Command), while still inheriting and utilizing any setup done by the parent.
        parent::__construct();
        $this->followupSurveyService = $followupSurveyService;
    }

    public function handle()
    {
        // Call the handle method of the FollowupSurveyService
        $this->followupSurveyService->handle();

        $this->info('Survey reminders sent successfully.');
    }
}
