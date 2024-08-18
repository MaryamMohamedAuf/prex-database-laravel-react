<?php

namespace App\Events;

use App\Models\Applicant;
use App\Models\Survey;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class SurveyReminderNeeded
{
    //Dispatchable: Adds the ability to dispatch the event using a static dispatch() method.
    //SerializesModels: Ensures that models and other data within the event are serialized and unserialized properly for queued listeners.
    use Dispatchable, SerializesModels;

    public $survey;

    public $applicant;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Survey $survey, Applicant $applicant)
    {
        $this->survey = $survey;
        $this->applicant = $applicant;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel[]
     */
    public function broadcastOn()
    {
        return [];
    }
}
