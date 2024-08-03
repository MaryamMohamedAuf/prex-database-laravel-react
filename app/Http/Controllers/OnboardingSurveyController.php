<?php
namespace App\Http\Controllers;

use App\Models\OnboardingSurvey;
use App\Models\Survey;
use App\Models\cohort;
use Illuminate\Support\Facades\Log;

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
            ]);
            $validatedData2 = $request->validate([
                'email' => 'nullable|email',
                'phone' => 'nullable|string',
                'material_due' => 'nullable|date',
            ]);
            $lastCohort = Cohort::latest('id')->first();
            if ($lastCohort) {
                $validatedData['cohort_id'] = $lastCohort->id;
                $validatedData2['cohort_id'] = $lastCohort->id;
            } else {
                return response()->json([
                    'message' => 'No cohort found'
                ], 400);
            }           
             $survey = Survey::create($validatedData);

            $survey->applicant_name = $validatedData['applicant_name'];
            $survey->cohort_tag = $validatedData['cohort_tag'];
            $survey->company_name = $validatedData['company_name'];
            $survey->save();

           Log::info('Created Survey:', $survey->toArray());
         $validatedData2['survey_id'] = $survey->id;
          $onboardingSurvey = OnboardingSurvey::create($validatedData2);
         Log::info('Created Onboarding Survey:', $onboardingSurvey->toArray());
        
            return response()->json([
                'message' => 'Onboarding Survey created successfully',
                'onboarding_survey' => $onboardingSurvey,
                'survey' => $survey
            ], 201);
        }
        

    public function show(OnboardingSurvey $onboardingSurvey, $id)
    {
       //$onboardingSurvey->load('survey'); // Eager load the associated survey
        //return response()->json($onboardingSurvey->load('survey'));
        Log::info('Fetching onboarding survey data for ' . $id);

        $onboardingSurvey = OnboardingSurvey::with('survey')->findOrFail($id);

        return response()->json($onboardingSurvey);

        return response()->json([
            'message' => 'Successfully fetched Onboarding Survey',
            'onboarding_survey' => $onboardingSurvey,
        ]);
    }

    public function update(Request $request, OnboardingSurvey $onboardingSurvey, $id)
    {
        $onboardingSurvey = OnboardingSurvey::findOrFail($id);
        $survey = Survey::find($onboardingSurvey->survey_id);
        $validatedData = $request->validate([
            'applicant_name' => 'required|string',
            'cohort_tag' => 'required|string',
            'company_name' => 'required|string',
            'email' => 'nullable|email',
            'phone' => 'nullable|string',
            'material_due' => 'nullable|string',
        ]);

        if (!$survey) 
        {
            return response()->json(['error' => 'Survey not found'], 404);
        } 
        else
        {
            $survey->applicant_name = $validatedData['applicant_name'];
            $survey->cohort_tag = $validatedData['cohort_tag'];
            $survey->company_name = $validatedData['company_name'];
            $survey->save();
        }
        // $survey->update([
        //     'applicant_name' => $validatedData['applicant_name'],
        //     'cohort_tag' => $validatedData['cohort_tag'],
        //     'company_name' => $validatedData['company_name']
        // ]);
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
            'survey'=> $survey
        ]);
    }

    public function destroy(OnboardingSurvey $onboardingSurvey, $id)
    {
        $onboardingSurvey = OnboardingSurvey::findOrFail($id);

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

