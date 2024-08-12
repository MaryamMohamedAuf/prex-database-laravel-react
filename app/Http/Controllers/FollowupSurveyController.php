<?php
namespace App\Http\Controllers;

use App\Models\Survey;
use App\Models\cohort;

use App\Models\FollowupSurvey;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Mail\SurveyReminder;
use Illuminate\Support\Facades\Mail;
use App\Models\Applicant;

class FollowupSurveyController extends Controller
{
    public function handle()
    {
        Log::info('Survey reminder handling started.');
        $surveys = FollowupSurvey::with('cohort')
            ->where('status', 'Pending')
            ->get();
          foreach ($surveys as $followupSurvey) {
            $dueDate = $followupSurvey->cohort->end_date;
            $survey = Survey::find($followupSurvey->survey_id);
            if ($survey) {
                $applicant = Applicant::where('company_name', $survey->company_name)->first();
                Log::info('Survey ID: ' . $survey->id);
                Log::info('Company Name: ' . $survey->company_name);
                if (now()->gt($dueDate)) {
                    Log::info('Sending email to: ' . $applicant->email);

                    Mail::to($applicant->email)->send(new SurveyReminder($survey, $applicant));

                    $survey->update(['status' => 'In Progress']);
                }
            } else {
                Log::warning('Survey not found for follow-up survey: ' . $followupSurvey->id);
            }
        }

        Log::info('Survey reminder handling completed.');
        }

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

    $survey = Survey::create($validatedSurveyData);
    $survey->applicant_name = $validatedSurveyData['applicant_name'];
    $survey->cohort_tag = $validatedSurveyData['cohort_tag'];
    $survey->company_name = $validatedSurveyData['company_name'];
    $survey->save();
    // $survey = Applicant::whereHas('round1', function ($query) use ($applicantData) {
    //     $query->where('company_name', $applicantData['company_name']);
    // })->first();

    // if (!$applicant) {
    //     // Return an error message if the applicant has not applied to Round 1
    //     return response()->json(['message' => 'Company name must be the same you entered in Round 1. If you did not apply to Round 1, please fill out its form first.'], 400);
    // }
    $validatedFollowupSurveyData['survey_id'] = $survey->id;
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
        'company_name' => 'required|string'
    ]);
    $validatedFollowupSurveyData = $request->validate([
        'date' => 'required|date',
        'survey_tag' => 'required|string',
        'status' => 'required|in:Completed,Pending,In Progress',
    ]);

    if ($survey) {
        $survey->update($validatedSurveyData);
        $survey->applicant_name = $validatedSurveyData['applicant_name'];
        $survey->cohort_tag = $validatedSurveyData['cohort_tag'];
        $survey->company_name = $validatedSurveyData['company_name'];
        $survey->save();
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
