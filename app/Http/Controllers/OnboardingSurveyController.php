<?php

namespace App\Http\Controllers;

use App\Http\Requests\OnboardingSurveyRequest;
use App\Http\Requests\SurveyRequest;
use App\Models\OnboardingSurvey;
use App\Services\OnboardingSurveyService;
use App\Services\SurveyService;
use Illuminate\Support\Facades\Log;

class OnboardingSurveyController extends Controller
{
    protected $onboardingSurveyService;

    protected $surveyService;

    public function __construct(OnboardingSurveyService $onboardingSurveyService, SurveyService $surveyService)
    {
        $this->onboardingSurveyService = $onboardingSurveyService;
        $this->surveyService = $surveyService;
    }

    public function getByCohort($cohortId)
    {
        $onboardingSurvey = $this->onboardingSurveyService->getByCohort($cohortId);

        return response()->json($onboardingSurvey);
    }

    public function index()
    {
        $onboardingSurveys = $this->onboardingSurveyService->getAllOnboardingSurveys();

        return response()->json($onboardingSurveys);
    }

    public function store(OnboardingSurveyRequest $onboardingSurveyRequest, SurveyRequest $surveyRequest)
    {
        // Validate the SurveyRequest data and create the Survey
        $validatedSurveyData = $surveyRequest->validated();
        $survey = $this->surveyService->createSurvey($validatedSurveyData);
        Log::info('Survey Request Data:', $surveyRequest->all());

        // Pass the survey_id and cohort_id to OnboardingSurveyRequest
        $onboardingSurveyData = $onboardingSurveyRequest->validated();
        $onboardingSurveyData['survey_id'] = $survey->id;
        $onboardingSurveyData['cohort_id'] = $survey->cohort_id;
        // Create the OnboardingSurvey using the validated data
        $onboardingSurvey = $this->onboardingSurveyService->createOnboardingSurvey($onboardingSurveyData);
        Log::info('Onboarding Survey Request Data:', $onboardingSurveyRequest->all());

        return response()->json([
            'message' => 'Onboarding survey created successfully',
            'onboardingSurvey' => $onboardingSurvey,
            'survey' => $survey,
        ], 201);
    }

    public function show(int $id)
    {
        $onboardingSurvey = $this->onboardingSurveyService->getOnboardingSurveyById($id);
        $survey_id = $onboardingSurvey->survey_id;
        $survey = $this->surveyService->getSurveyById($survey_id);

        return response()->json([
            'onboardingSurvey' => $onboardingSurvey,
            'survey' => $survey,
        ], 201);
    }

    public function update(SurveyRequest $request2, OnboardingSurveyRequest $request, int $id)
    {
        $survey = $this->surveyService->updateSurvey($id, $request2->validated());
        $onboardingSurvey = $this->onboardingSurveyService->updateOnboardingSurvey($id, $request->validated());

        return response()->json([
            'message' => 'Onboarding survey updated successfully',
            'onboardingSurvey' => $onboardingSurvey,
            'survey' => $survey,
        ], 200);
    }

    public function destroy(int $id)
    {
        $this->onboardingSurveyService->deleteOnboardingSurvey($id);

        return response()->json([
            'message' => 'Onboarding survey deleted successfully',
        ], 200);
    }
}
