<?php
namespace App\Http\Controllers;

use App\Models\OnboardingSurvey;
use App\Models\Survey;
use App\Models\cohort;

use Illuminate\Http\Request;

class OnboardingSurveyController extends Controller
{
    public function getByCohort($cohortId)
{
    $round1s = OnboardingSurvey::with('survey')->where('cohort_id', $cohortId)->get();
    return response()->json($round1s);
}
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
        'applicant_name' => 'required|string',
        'cohort_tag' => 'required|string',
        'company_name' => 'required|string',
        'email' => 'nullable|email',
        'phone' => 'nullable|string',
        'material_due' => 'nullable|date',
    ]);

    // Retrieve the last inserted cohort_id from the cohort table
    $lastCohort = Cohort::latest('id')->first();
    if ($lastCohort) {
        $validatedData['cohort_id'] = $lastCohort->id;
    } else {
        return response()->json([
            'message' => 'No cohort found'
        ], 400);
    }

    // Create or update Survey record
    $survey = Survey::updateOrCreate(
    ['applicant_name' => $validatedData['applicant_name'],
     'cohort_tag' => $validatedData['cohort_tag'],
     'company_name' => $validatedData['company_name'],
     'cohort_id' => $lastCohort->id
    ],
    );

    // Create OnboardingSurvey record linked to Survey
    $onboardingSurvey = OnboardingSurvey::create([
        'survey_id' => $survey->id,
        'email' => $validatedData['email'],
        'phone' => $validatedData['phone'],
        'material_due' => $validatedData['material_due'],
       'cohort_id' => $validatedData['cohort_id'],
    ]);

    return response()->json([
        'message' => 'Onboarding Survey created successfully',
        'onboarding_survey' => $onboardingSurvey,
    ], 201);
}

    public function show(OnboardingSurvey $onboardingSurvey)
    {
       // $onboardingSurvey->load('survey'); // Eager load the associated survey
        return response()->json($onboardingSurvey->load('survey'));


        // return response()->json([
        //     'message' => 'Successfully fetched Onboarding Survey',
        //     'onboarding_survey' => $onboardingSurvey,
        //]);
    }

    public function update(Request $request, OnboardingSurvey $onboardingSurvey)
    {
        $validatedData = $request->validate([
            'applicant_name' => 'required|string',
            'cohort_tag' => 'required|string',
            'company_name' => 'required|string',
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
            'applicant_name' => $validatedData['applicant_name'],
            'cohort_tag' => $validatedData['cohort_tag'],
            'company_name' => $validatedData['company_name']
        ]);
        
        $lastCohort = Cohort::latest('id')->first();
        if ($lastCohort) {
            $validatedData['cohort_id'] = $lastCohort->id;
        } else {
            return response()->json([
                'message' => 'No cohort found'
            ], 400);
        }
        $onboardingSurvey->update([
            'email' => $validatedData['email'],
            'phone' => $validatedData['phone'],
            'material_due' => $validatedData['material_due'],
            'cohort_id' => $validatedData['cohort_id']
        ]);

        return response()->json([
            'message' => 'Onboarding Survey updated successfully',
            'onboarding_survey' => $onboardingSurvey,
        ]);
    }

    public function destroy(OnboardingSurvey $onboardingSurvey)
    {
        // Find the Survey associated with the OnboardingSurvey
        $survey = Survey::find($onboardingSurvey->survey_id);
    
        $onboardingSurvey->delete();
    
        if ($survey) {
            $survey->delete();
        }
    
        return response()->json([
            'message' => 'Onboarding Survey and associated Survey deleted successfully',
        ]);
    }
    

        

    }

