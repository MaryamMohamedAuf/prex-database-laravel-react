<?php

namespace App\Services;

use App\Models\OnboardingSurvey;
use App\Models\Survey;

class OnboardingSurveyService
{
    /**
     * Create a new onboarding survey.
     */
    public function createOnboardingSurvey(array $data): OnboardingSurvey
    {
        return OnboardingSurvey::create($data);
    }

    /**
     * Retrieve an onboarding survey by its ID.
     */
    public function getOnboardingSurveyById(int $id): OnboardingSurvey
    {
        return OnboardingSurvey::findOrFail($id);
    }

    /**
     * Update an existing onboarding survey.
     */
    public function updateOnboardingSurvey(int $id, array $data): OnboardingSurvey
    {
        $onboardingSurvey = $this->getOnboardingSurveyById($id);
        $onboardingSurvey->update($data);

        return $onboardingSurvey;
    }

    /**
     * Delete an onboarding survey by its ID.
     */
    public function deleteOnboardingSurvey(int $id): bool
    {
        $onboardingSurvey = $this->getOnboardingSurveyById($id);

        return $onboardingSurvey->delete();
    }

    public function getAllOnboardingSurveys()
    {
        return OnboardingSurvey::all();
    }

    public function getByCohort($cohortId)
    {
        return OnboardingSurvey::with('survey')->where('cohort_id', $cohortId)->get();
    }
}
