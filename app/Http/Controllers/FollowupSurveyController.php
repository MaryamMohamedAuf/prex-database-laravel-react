<?php

namespace App\Http\Controllers;

use App\Http\Requests\FollowupSurveyRequest;
use App\Http\Requests\SurveyRequest;
use App\Services\FollowupSurveyService;
use App\Services\SurveyService;
use Illuminate\Support\Facades\Log;

class FollowupSurveyController extends Controller
{
    protected $followupSurveyService;

    protected $surveyService;

    public function __construct(FollowupSurveyService $followupSurveyService, SurveyService $surveyService)
    {
        $this->followupSurveyService = $followupSurveyService;
        $this->surveyService = $surveyService;
    }

    public function handleSurveyReminders()
    {
        Log::info('Survey reminder handling started.');

        $this->followupSurveyService->handle();

        Log::info('Survey reminder handling completed.');

        return response()->json(['message' => 'Survey reminders processed successfully.']);
    }

    public function getByCohort($cohortId)
    {
        $followupSurveys = $this->followupSurveyService->getByCohort($cohortId);

        return response()->json($followupSurveys);
    }

    public function index()
    {
        $followupSurveys = $this->followupSurveyService->getAllFollowupSurveys();

        return response()->json($followupSurveys);
    }

    public function store(FollowupSurveyRequest $followupSurveyRequest, SurveyRequest $surveyRequest)
    {
        // Validate the SurveyRequest data and create the Survey
        $validatedSurveyData = $surveyRequest->validated();
        $survey = $this->surveyService->createSurvey($validatedSurveyData);
        Log::info('Survey Request Data:', $surveyRequest->all());

        // Pass the survey_id and cohort_id to FollowupSurveyRequest
        $followupSurveyData = $followupSurveyRequest->validated();
        $followupSurveyData['survey_id'] = $survey->id;
        $followupSurveyData['cohort_id'] = $survey->cohort_id;
        // Create the FollowupSurvey using the validated data
        $followupSurvey = $this->followupSurveyService->createFollowupSurvey($followupSurveyData);
        Log::info('Follow-up Survey Request Data:', $followupSurveyRequest->all());

        return response()->json([
            'message' => 'Follow-up survey created successfully',
            'followupSurvey' => $followupSurvey,
            'survey' => $survey,
        ], 201);
    }

    public function show(int $id)
    {
        $followupSurvey = $this->followupSurveyService->getFollowupSurveyById($id);
        $survey_id = $followupSurvey->survey_id;
        $survey = $this->surveyService->getSurveyById($survey_id);

        return response()->json([
            'followup' => $followupSurvey,
            'survey' => $survey,
        ], 201);
    }

    public function update(SurveyRequest $request2, FollowupSurveyRequest $request, int $id)
    {
        $survey = $this->surveyService->updateSurvey($id, $request2->validated());
        $followupSurvey = $this->followupSurveyService->updateFollowupSurvey($id, $request->validated());

        return response()->json([
            'message' => 'Follow-up survey updated successfully',
            'followupSurvey' => $followupSurvey,
            'survey' => $survey,
        ], 200);
    }

    public function destroy(int $id)
    {
        $this->followupSurveyService->deleteFollowupSurvey($id);

        return response()->json([
            'message' => 'Follow-up survey deleted successfully',
        ], 200);
    }
}
