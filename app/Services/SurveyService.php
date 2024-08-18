<?php

namespace App\Services;

use App\Models\Survey;

class SurveyService
{
    /**
     * Create a new survey.
     */
    public function createSurvey(array $data): Survey
    {
        return Survey::create($data);
    }

    /**
     * Retrieve a survey by its ID.
     */
    public function getSurveyById(int $id): Survey
    {
        return Survey::findOrFail($id);
    }

    /**
     * Update an existing survey.
     */
    public function updateSurvey(int $id, array $data): Survey
    {
        $survey = $this->getSurveyById($id);
        $survey->update($data);

        return $survey;
    }

    /**
     * Delete a survey by its ID.
     */
    public function deleteSurvey(int $id): bool
    {
        $survey = $this->getSurveyById($id);

        return $survey->delete();
    }

    /**
     * Retrieve all surveys.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getAllSurveys()
    {
        return Survey::all();
    }
}
