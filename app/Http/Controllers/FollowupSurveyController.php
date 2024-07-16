<?php
namespace App\Http\Controllers;

use App\Models\Survey;
use App\Models\FollowupSurvey;
use Illuminate\Http\Request;

class FollowupSurveyController extends Controller
{
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
        // Validate data for both tables
        $validatedSurveyData = $request->validate([
            'ApplicantName' => 'required|string',
            'CohortTag' => 'required|string',
        ]);
    
        $validatedFollowupSurveyData = $request->validate([
            'date' => 'required|date',
            'survey_tag' => 'required|string',
            'status' => 'required|in:Completed,Pending,In Progress',
        ]);
    
        // Create a new survey entry (super entity)
        $survey = Survey::create($validatedSurveyData);
    
        // Add the survey_id to the validated data for followup_survey
        $validatedFollowupSurveyData['survey_id'] = $survey->id;
    
        // Create the followup survey entry (sub-entity)
        $followupSurvey = FollowupSurvey::create($validatedFollowupSurveyData);
    
        return response()->json([
            'message' => 'Followup Survey created successfully',
            'followup_survey' => $followupSurvey,
            'survey' => $survey, // Optionally return the created survey as well
        ], 201);
    }
    

    /**
     * Display the specified resource.
     */
    public function show(FollowupSurvey $followupSurvey)
    {
        return response()->json($followupSurvey->load('survey'));
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
    public function update(Request $request, FollowupSurvey $followupSurvey)
{
    // Validate data for both tables
    $validatedSurveyData = $request->validate([
        'ApplicantName' => 'required|string',
        'CohortTag' => 'required|string',
    ]);

    $validatedFollowupSurveyData = $request->validate([
        'date' => 'required|date',
        'survey_tag' => 'required|string',
        'status' => 'required|in:Completed,Pending,In Progress',
    ]);

    // Retrieve the associated survey
    $survey = Survey::find($followupSurvey->survey_id);

    // Update the survey data
    if ($survey) {
        $survey->update($validatedSurveyData);
    }

    // Update the followup survey data
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
    public function destroy(FollowupSurvey $followupSurvey)
    {
        // Retrieve the associated survey
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