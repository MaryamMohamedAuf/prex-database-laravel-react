<?php
namespace App\Http\Controllers;

use App\Models\Survey;
use App\Models\cohort;

use App\Models\FollowupSurvey;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;


class FollowupSurveyController extends Controller
{
    public function getByCohort($cohortId)
{
    $round1s = FollowupSurvey::with('survey')->where('cohort_id', $cohortId)->get();
    return response()->json($round1s);
}
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $followupSurveys = FollowupSurvey::with('survey')->get();
        return response()->json($followupSurveys);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
{
    $validatedSurveyData = $request->validate([
        'applicant_name' => 'required|string',
        'company_name' => 'required|string',
        'cohort_tag' => 'required|string'
    ]);

    $validatedFollowupSurveyData = $request->validate([
        'date' => 'required|date',
        'survey_tag' => 'required|string',
        'status' => 'required|in:Completed,Pending,In Progress',
    ]);

    // Retrieve the last inserted cohort_id from the cohort table
    $lastCohort = Cohort::latest('id')->first();
    if ($lastCohort) {
        $validatedFollowupSurveyData['cohort_id'] = $lastCohort->id;
        $validatedSurveyData['cohort_id'] = $lastCohort->id;

    } else {
        return response()->json([
            'message' => 'No cohort found'
        ], 400);
    }

    // Create a new survey entry (super entity)
    $survey = Survey::create($validatedSurveyData);

    // Add the survey_id to the validated data for followup_survey
    $validatedFollowupSurveyData['survey_id'] = $survey->id;

    // Create the followup survey entry (sub-entity)
    $followupSurvey = FollowupSurvey::create($validatedFollowupSurveyData);

    return response()->json([
        'message' => 'Followup Survey created successfully',
        'followup_survey' => $followupSurvey,
        'survey' => $survey, // return the created survey as well
    ], 201);
}
    

    /**
     * Display the specified resource.
     */
    public function show(FollowupSurvey $followupSurvey ,$id)
    {
       // return response()->json($followupSurvey->load('survey'));
        Log::info('Fetching follow up survey data for ' . $id);

        $followupSurvey = FollowupSurvey::with('survey')->findOrFail($id);

        return response()->json($followupSurvey);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(FollowupSurvey $followupSurvey)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, FollowupSurvey $followupSurvey, $id)
{
    $followupSurvey = followupSurvey::findOrFail($id);
    $survey = Survey::find($followupSurvey->survey_id);

    $validatedSurveyData = $request->validate([
        'applicant_name' => 'required|string',
        'cohort_tag' => 'required|string',
        'company_name' => 'nullable|string'
    ]);
    $validatedFollowupSurveyData = $request->validate([
        'date' => 'required|date',
        'survey_tag' => 'required|string',
        'status' => 'required|in:Completed,Pending,In Progress',
    ]);

    if ($survey) {
        $survey->update($validatedSurveyData);
    }
    $followupSurvey->update($validatedFollowupSurveyData);

    return response()->json([
        'message' => 'Followup Survey and associated Survey updated successfully',
        'followup_survey' => $followupSurvey,
        'survey' => $survey, // Optionally return the updated survey as well
    ]);
}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(FollowupSurvey $followupSurvey, $id)
    {
        $followupSurvey = FollowupSurvey::findOrFail($id);
        $survey = Survey::find($followupSurvey->survey_id);
    
        // Delete the followup survey
        $followupSurvey->delete();
    
        // Delete the associated survey if found
        if ($survey) {
            $survey->delete();
        }
    
        return response()->json([
            'message' => 'Followup Survey and associated Survey deleted successfully'
        ]);
    }
    
}
