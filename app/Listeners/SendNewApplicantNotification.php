<?php

namespace App\Listeners;

use App\Events\ApplicantCreated;
use App\Models\User;
use App\Notifications\NewApplicantNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;

class SendNewApplicantNotification
//implements ShouldQueue
{
    /**
     * Handle the event.
     *
     * @return void
     */
    public function handle(ApplicantCreated $event)
    {
        Log::info('SendNewApplicantNotification listener triggered.');

        Notification::send(User::all(), new NewApplicantNotification($event->applicant));

    }
}
