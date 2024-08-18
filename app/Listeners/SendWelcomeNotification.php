<?php

namespace App\Listeners;

use App\Events\UserRegistered;
use App\Notifications\NewAdminNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;

class SendWelcomeNotification implements ShouldQueue
{
    /**
     * Handle the event.
     *
     * @return void
     */
    public function handle(UserRegistered $event)
    {
        Log::info('SendWelcomeNotification listener triggered.');

        Notification::route('mail', $event->user->email)->notify(new NewAdminNotification($event->user));

    }
}
