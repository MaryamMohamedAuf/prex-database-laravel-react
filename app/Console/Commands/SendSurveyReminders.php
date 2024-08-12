<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\FollowupSurveyController;

class SendSurveyReminders extends Command
{
    protected $signature = 'survey:send-reminders';
    protected $description = 'Send reminders for follow-up surveys';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        // Instantiate the controller and call the handle method
        $controller = new FollowupSurveyController();
        $controller->handle();

        $this->info('Survey reminders sent successfully.');
    }
}
