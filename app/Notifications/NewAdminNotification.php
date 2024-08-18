<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewAdminNotification extends Notification
{
    use Queueable;

    protected $user;

    public function __construct($user)
    {
        $this->user = $user;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Your Admin Account has been Created')
            ->greeting('Hello '.$this->user->name.',')
            ->line('Your admin account has been successfully created.')
            ->line('You can now log in using your email: '.$this->user->email.'  password')
            ->action('Login', url('http://localhost:3000/'))
            ->line('Please log in and change your password as soon as possible.')
            ->line('Thank you for being part of our platform!');
    }

    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
