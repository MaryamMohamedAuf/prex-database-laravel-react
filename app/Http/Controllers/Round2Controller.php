<?php

namespace App\Http\Controllers;

use App\Models\Applicant;
use App\Models\Cohort;
use App\Models\Round2;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class Round2Controller extends Controller
{
    public function getByCohort($cohortId)
{
    $round1s = Round2::with('applicant')->where('cohort_id', $cohortId)->get();
    return response()->json($round1s);
}
    public function index($cohortId)
    {
        $cohortId = session('cohort_id');

        if (!$cohortId) {
            return response()->json(['error' => 'Cohort ID not found in session'], 400);
        }

        $cohort = Cohort::find($cohortId);
        if (!$cohort) {
            return response()->json(['error' => 'Cohort not found'], 404);
        }

        // Retrieve all round2 entries with associated applicant and cohort data
        $round2s = Round2::with(['applicant', 'cohort'])->where('cohort_id', $cohortId)->get();

        return response()->json($round2s);
    }

    public function store(Request $request)
    {
        try {
            Log::info('Request data:', $request->all());

            // Validate request data for applicants table
            $applicantData = $request->validate([
                'first_name' => 'required|string',
                'last_name' => 'required|string',
                'email' => 'required|email|unique:applicants,email',
                'company_name' => 'required|string',
            ]);
            $applicant = Applicant::whereHas('round1', function ($query) use ($applicantData) {
                $query->where('company_name', $applicantData['company_name']);
            })->first();
    
            if (!$applicant) {
                // Return an error message if the applicant has not applied to Round 1
                return response()->json(['message' => 'Company name must be the same you entered in Round 1. If you did not apply to Round 1, please fill out its form first.'], 400);
            }
            // Get the last cohort ID
            $lastCohort = Cohort::latest('id')->first();
            if (!$lastCohort) {
                return response()->json(['message' => 'No cohort found'], 400);
            }
            $applicantData['cohort_id'] = $lastCohort->id;

            // Create an applicant entry
           // $applicant = Applicant::create($applicantData);
           // Log::info('Applicant created:', ['applicant_id' => $applicant->id]);

            // Validate request data for round2s table
            $round2Data = $request->validate([
                'phone' => 'nullable|string',
                'One_Sentence_Description' => 'nullable|string|max:125',
                'sector' => 'required|string',
                'other_sector' => 'nullable|string',
                'business_model' => 'required|string',
                'other_business_model' => 'nullable|string',
                'solution' => 'required|string',
                'other_solution' => 'nullable|string',
                'demo_url' => 'nullable|string',
                'traction' => 'required|string',
                'where_customer_find_solution' => 'required|string',
                'revenue_generated' => 'required|string',
                'funding_received' => 'required|array',
                'other_funding_type' => 'nullable|string',
                'sources_of_funding' => 'required|array',
                'core_team_members' => 'required|integer',
                'previous_startup_experience' => 'required|boolean',
                'core_team' => 'nullable|string',
                'core_team_experience' => 'nullable|string',
                'employees_full_time_part_time_interns' => 'required|string',
                'positions_to_fill' => 'nullable|string',
                'goals_next_3_to_12_months' => 'required|string',
                'prex_program_expectations' => 'required|string',
                'accomplish_within_year' => 'required|array',
                'submit_pitch_video_url' => 'required|string',
                'covid19_resilience_impact' => 'nullable|string',
                'social_impact' => 'required|string',
                'covid19_impact' => 'required|array',
                'other_covid19_impact' => 'nullable|string',
                'critical_support_resource' => 'required|array',
                'best_support_resource' => 'required|array',
                'holding_back_growth_reason' => 'nullable|string',
                'other_comments' => 'nullable|string',
                'race_ethnicity' => 'nullable|array',
                'gender' => 'nullable|array',
                'team_identifiers' => 'nullable|array',
                'if_other_team_identifiers' => 'nullable|string',
            ]);

            // Add applicant_id and cohort_id to round2Data
            $round2Data['applicant_id'] = $applicant->id;
            $round2Data['cohort_id'] = $lastCohort->id;

            // Convert arrays to comma-separated strings
            $round2Data['funding_received'] = implode(',', $round2Data['funding_received']);
            $round2Data['sources_of_funding'] = implode(',', $round2Data['sources_of_funding']);
            $round2Data['accomplish_within_year'] = implode(',', $round2Data['accomplish_within_year']);
            $round2Data['covid19_impact'] = implode(',', $round2Data['covid19_impact']);
            $round2Data['critical_support_resource'] = implode(',', $round2Data['critical_support_resource']);
            $round2Data['best_support_resource'] = implode(',', $round2Data['best_support_resource']);
            $round2Data['race_ethnicity'] = isset($round2Data['race_ethnicity']) ? implode(',', $round2Data['race_ethnicity']) : null;
            $round2Data['gender'] = isset($round2Data['gender']) ? implode(',', $round2Data['gender']) : null;
            $round2Data['team_identifiers'] = isset($round2Data['team_identifiers']) ? implode(',', $round2Data['team_identifiers']) : null;

            Log::info('Round2 Data:', $round2Data);

            // Create a new round2 entry
            $round2 = Round2::create($round2Data);
            Log::info('Round2 created:', ['round2_id' => $round2->id]);

            return response()->json(['applicant' => $applicant, 'round2' => $round2], 201);
        } catch (\Exception $e) {
            Log::error('Error saving data:', ['message' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
            return response()->json(['message' => 'Error saving data'], 500);
        }
    }

    public function show($id)
    {
        // Retrieve the round2 entry by id including related applicant data
        $round2 = Round2::with('applicant')->findOrFail($id);

        return response()->json($round2);
    }

    public function update(Request $request, $round2Id)
    {
        try {
            // Find the applicant and round2 instances
            $round2 = Round2::findOrFail($round2Id);
            $applicant = $round2->applicant;

            // Validate data for both tables
            $validatedApplicantData = $request->validate([
                'first_name' => 'required|string|max:255',
                'last_name' => 'required|string|max:255',
                'email' => 'required|email|unique:applicants,email,' . $applicant->id,
                'company_name' => 'required|string|max:255',
            ]);

            $validatedRound2Data = $request->validate([
                'phone' => 'nullable|string|max:255',
                'One-Sentence_Description' => 'nullable|string|max:125',
                'sector' => 'required|string|max:255',
                'other_sector' => 'nullable|string|max:255',
                'business_model' => 'required|string|max:255',
                'other_business_model' => 'nullable|string|max:255',
                'solution' => 'required|string|max:255',
                'other_solution' => 'nullable|string|max:255',
                'demo_url' => 'nullable|string|max:255',
                'traction' => 'required|string|max:255',
                'where_customer_find_solution' => 'required|string|max:255',
                'revenue_generated' => 'required|string|max:255',
                'funding_received' => 'required|array',
                'other_funding_type' => 'nullable|string|max:255',
                'sources_of_funding' => 'required|array',
                'core_team_members' => 'required|integer',
                'previous_startup_experience' => 'required|boolean',
                'core_team' => 'nullable|string|max:255',
                'core_team_experience' => 'nullable|string|max:255',
                'employees_full_time_part_time_interns' => 'required|string|max:255',
                'positions_to_fill' => 'nullable|string|max:255',
                'goals_next_3_to_12_months' => 'required|string|max:255',
                'prex_program_expectations' => 'required|string|max:255',
                'accomplish_within_year' => 'required|array',
                'submit_pitch_video_url' => 'required|string|max:255',
                'covid19_resilience_impact' => 'nullable|string|max:255',
                'social_impact' => 'required|string|max:255',
                'covid19_impact' => 'required|array',
                'other_covid19_impact' => 'nullable|string|max:255',
                'critical_support_resource' => 'required|array',
                'best_support_resource' => 'required|array',
                'holding_back_growth_reason' => 'nullable|string|max:255',
                'other_comments' => 'nullable|string|max:65535',
                'race_ethnicity' => 'nullable|array',
                'gender' => 'nullable|array',
                'team_identifiers' => 'nullable|array',
                'if_other_team_identifiers' => 'nullable|string|max:255',
            ]);

            // Convert arrays to comma-separated strings
            $validatedRound2Data['funding_received'] = implode(',', $validatedRound2Data['funding_received']);
            $validatedRound2Data['sources_of_funding'] = implode(',', $validatedRound2Data['sources_of_funding']);
            $validatedRound2Data['accomplish_within_year'] = implode(',', $validatedRound2Data['accomplish_within_year']);
            $validatedRound2Data['covid19_impact'] = implode(',', $validatedRound2Data['covid19_impact']);
            $validatedRound2Data['critical_support_resource'] = implode(',', $validatedRound2Data['critical_support_resource']);
            $validatedRound2Data['best_support_resource'] = implode(',', $validatedRound2Data['best_support_resource']);
            $validatedRound2Data['race_ethnicity'] = isset($validatedRound2Data['race_ethnicity']) ? implode(',', $validatedRound2Data['race_ethnicity']) : null;
            $validatedRound2Data['gender'] = isset($validatedRound2Data['gender']) ? implode(',', $validatedRound2Data['gender']) : null;
            $validatedRound2Data['team_identifiers'] = isset($validatedRound2Data['team_identifiers']) ? implode(',', $validatedRound2Data['team_identifiers']) : null;

            // Update the applicant and round2 instances
            $applicant->update($validatedApplicantData);
            $round2->update($validatedRound2Data);

            return response()->json(['applicant' => $applicant, 'round2' => $round2]);
        } catch (\Exception $e) {
            Log::error('Error updating data:', ['message' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
            return response()->json(['message' => 'Error updating data'], 500);
        }
    }

    public function destroy($id)
    {
        $round2 = Round2::findOrFail($id);
        $round2->delete();

        return response()->json(['message' => 'Round 2 entry deleted successfully']);
    }
}
