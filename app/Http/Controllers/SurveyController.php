<?php

namespace App\Http\Controllers;

use App\Http\Requests\SurveyRequest;
use App\Services\SurveyService;

class SurveyController extends Controller
{
    protected $surveyService;

    /**
     * Create a new controller instance.
     */
    public function __construct(SurveyService $surveyService)
    {
        $this->surveyService = $surveyService;
    }

    /**
     * Display a listing of the surveys.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $surveys = $this->surveyService->getAllSurveys();

        return response()->json($surveys);
    }

    /**
     * Store a newly created survey in storage.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(SurveyRequest $request)
    {
        $survey = $this->surveyService->createSurvey($request->validated());

        return response()->json([
            'message' => 'Survey created successfully',
            'survey' => $survey,
        ], 201);
    }

    /**
     * Display the specified survey.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(int $id)
    {
        $survey = $this->surveyService->getSurveyById($id);

        return response()->json($survey);
    }

    /**
     * Update the specified survey in storage.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(SurveyRequest $request, int $id)
    {
        $survey = $this->surveyService->updateSurvey($id, $request->validated());

        return response()->json([
            'message' => 'Survey updated successfully',
            'survey' => $survey,
        ], 200);
    }

    /**
     * Remove the specified survey from storage.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(int $id)
    {
        $this->surveyService->deleteSurvey($id);

        return response()->json([
            'message' => 'Survey deleted successfully',
        ], 200);
    }
}
