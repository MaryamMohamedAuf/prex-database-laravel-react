<?php

namespace App\Providers;

use App\Events\ApplicantCreated;
use App\Events\SurveyReminderNeeded;
use App\Events\UserRegistered;
use App\Listeners\SendNewApplicantNotification;
use App\Listeners\SendSurveyReminder;
use App\Listeners\SendWelcomeNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        ApplicantCreated::class => [
            SendNewApplicantNotification::class,
        ],
        UserRegistered::class => [
            SendWelcomeNotification::class,
        ],
        SurveyReminderNeeded::class => [
            SendSurveyReminder::class,
        ],
    ];

    // ...
}
