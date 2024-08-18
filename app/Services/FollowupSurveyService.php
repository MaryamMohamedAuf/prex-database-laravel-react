<?php

namespace App\Services;

use App\Events\SurveyReminderNeeded;
use App\Models\applicant;
use App\Models\FollowupSurvey;
use App\Models\Survey;
use Illuminate\Support\Facades\Log;

class FollowupSurveyService
{
    /**
     * Create a new follow-up survey.
     */
    public function createFollowupSurvey(array $data): FollowupSurvey
    {
        return FollowupSurvey::create($data);
    }

    public function handle()
    {
        Log::info('Survey reminder handling started.');
        $surveys = FollowupSurvey::with('cohort')
            ->where('status', 'Pending')
            ->get();

        foreach ($surveys as $followupSurvey) {
            $dueDate = $followupSurvey->cohort->end_date;
            $survey = Survey::find($followupSurvey->survey_id);
            if ($survey) {
                $applicant = Applicant::where('company_name', $survey->company_name)->first();
                Log::info('Survey ID: '.$survey->id);
                Log::info('Company Name: '.$survey->company_name);
                //now(): This function is a helper provided by Laravel that returns the current date and time as a Carbon instance. Carbon is a PHP library for date and time manipulation.
                //gt($dueDate): This method stands for "greater than" and is a comparison method provided by the Carbon library. It checks if the now() value (current date and time) is greater than the $dueDate.
                if (now()->gt($dueDate)) {
                    Log::info('Dispatching SurveyReminderNeeded event for: '.$applicant->email);
                    event(new SurveyReminderNeeded($survey, $applicant));
                    $survey->update(['status' => 'In Progress']);
                }
            } else {
                Log::warning('Survey not found for follow-up survey: '.$followupSurvey->id);
            }
        }

        Log::info('Survey reminder handling completed.');
    }

    /**
     * Retrieve a follow-up survey by its ID.
     */
    public function getFollowupSurveyById(int $id): FollowupSurvey
    {
        return FollowupSurvey::findOrFail($id);
    }

    /**
     * Update an existing follow-up survey.
     */
    public function updateFollowupSurvey(int $id, array $data): FollowupSurvey
    {
        $followupSurvey = $this->getFollowupSurveyById($id);
        $followupSurvey->update($data);

        return $followupSurvey;
    }

    /**
     * Delete a follow-up survey by its ID.
     */
    public function deleteFollowupSurvey(int $id): bool
    {
        $followupSurvey = $this->getFollowupSurveyById($id);

        return $followupSurvey->delete();
    }

    /**
     * Retrieve all follow-up surveys.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getAllFollowupSurveys()
    {
        return FollowupSurvey::all();
    }

    public function getByCohort($cohortId)
    {
        return FollowupSurvey::with('survey')->where('cohort_id', $cohortId)->get();
    }
}
