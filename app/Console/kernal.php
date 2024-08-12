<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    
    protected $commands = [
        \App\Console\Commands\SendSurveyReminders::class,
    ];
    protected $signature = 'survey:send-reminders';

    protected function schedule(Schedule $schedule)
    {
        $schedule->command('survey:send-reminders')->daily();
    }
}
