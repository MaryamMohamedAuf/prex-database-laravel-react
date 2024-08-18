<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\Log;

class Kernel extends ConsoleKernel
{
    protected $commands = [
        \App\Console\Commands\SendSurveyReminders::class,
    ];

    protected $signature = 'survey:send-reminders';

    protected function schedule(Schedule $schedule)
    {
        //$schedule->command('survey:send-reminders')->daily();
        $schedule->command('survey:send-reminders')->dailyAt('08:00')
      //  $schedule->command('survey:send-reminders')->everyMinute()
            ->before(function () {
                Log::info('About to run survey:send-reminders');
            })
            ->after(function () {
                Log::info('Finished running survey:send-reminders');
            });
    }
}
