<?php
namespace App\Http\Controllers;

use App\Models\OnboardingSurvey;
use App\Models\Survey;
use Illuminate\Http\Request;

class OnboardingSurveyController extends Controller
{
    public function index()
    {
        $onboardingSurveys = OnboardingSurvey::with('survey')->get();

        return response()->json([
            'message' => 'Successfully fetched onboarding surveys',
            'onboarding_surveys' => $onboardingSurveys,
        ]);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'ApplicantName' => 'required|string',
            'CohortTag' => 'required|string',
            'email' => 'nullable|email',
            'phone' => 'nullable|string',
            'material_due' => 'nullable|string',
        ]);

        // Create or update Survey record
        $survey = Survey::updateOrCreate(
            ['ApplicantName' => $validatedData['ApplicantName'], 'CohortTag' => $validatedData['CohortTag']],
            ['ApplicantName' => $validatedData['ApplicantName'], 'CohortTag' => $validatedData['CohortTag']]
        );

        // Create OnboardingSurvey record linked to Survey
        $onboardingSurvey = OnboardingSurvey::create([
            'survey_id' => $survey->id,
            'email' => $validatedData['email'],
            'phone' => $validatedData['phone'],
            'material_due' => $validatedData['material_due'],
        ]);

        return response()->json([
            'message' => 'Onboarding Survey created successfully',
            'onboarding_survey' => $onboardingSurvey,
        ], 201);
    }

    public function show(OnboardingSurvey $onboardingSurvey)
    {
        $onboardingSurvey->load('survey'); // Eager load the associated survey

        return response()->json([
            'message' => 'Successfully fetched Onboarding Survey',
            'onboarding_survey' => $onboardingSurvey,
        ]);
    }

    public function update(Request $request, OnboardingSurvey $onboardingSurvey)
    {
        $validatedData = $request->validate([
            'ApplicantName' => 'required|string',
            'CohortTag' => 'required|string',
            'email' => 'nullable|email',
            'phone' => 'nullable|string',
            'material_due' => 'nullable|string',
        ]);

        // Update Survey record
        $survey = Survey::find($onboardingSurvey->survey_id);
        if (!$survey) {
            return response()->json(['error' => 'Survey not found'], 404);
        }

        $survey->update([
            'ApplicantName' => $validatedData['ApplicantName'],
            'CohortTag' => $validatedData['CohortTag'],
        ]);

        // Update OnboardingSurvey record
        $onboardingSurvey->update([
            'email' => $validatedData['email'],
            'phone' => $validatedData['phone'],
            'material_due' => $validatedData['material_due'],
        ]);

        return response()->json([
            'message' => 'Onboarding Survey updated successfully',
            'onboarding_survey' => $onboardingSurvey,
        ]);
    }

    public function destroy(OnboardingSurvey $onboardingSurvey)
    {
        // Delete Survey record associated with OnboardingSurvey
        $survey = Survey::find($onboardingSurvey->survey_id);
        if ($survey) {
            $survey->delete();
        }

        // Delete OnboardingSurvey record
        $onboardingSurvey->delete();

        return response()->json([
            'message' => 'Onboarding Survey and associated Survey deleted successfully',
        ]);
    }
}
