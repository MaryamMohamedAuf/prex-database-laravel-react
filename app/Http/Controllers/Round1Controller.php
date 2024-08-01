<?php

namespace App\Http\Controllers;

use App\Models\Applicant;
use App\Models\Cohort;
use App\Models\Round1;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class Round1Controller extends Controller
{
// In app/Http/Controllers/Round1Controller.php
public function getByCohort($cohortId)
{
    $round1s = Round1::with('applicant')->where('cohort_id', $cohortId)->get();
    return response()->json($round1s);
}

    public function index($cohortId)
    {
        
        // Retrieve all round1 entries with associated applicant and cohort data
        $round1s = Round1::with(['applicant', 'cohort'])->where('cohort_id', $cohortId)->get();

        return response()->json($round1s);
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

            // Get the last cohort ID
            $lastCohort = Cohort::latest('id')->first();
            if (!$lastCohort) {
                return response()->json(['message' => 'No cohort found'], 400);
            }
            $applicantData['cohort_id'] = $lastCohort->id;

            // Create an applicant entry
            $applicant = Applicant::create($applicantData);
            Log::info('Applicant created:', ['applicant_id' => $applicant->id]);

            // Validate request data for round1s table
            $round1Data = $request->validate([
                'company_website' => 'nullable|url',
                'company_zip_code' => 'required|string',
                'year_company_founded' => 'nullable|integer',
                'number_of_founding_team_members' => 'required|integer',
                'current_product_stage' => 'required|string',
                'current_business_stage' => 'required|string',
                'company_formed' => 'required|string',
                'one_sentence_description' => 'required|string|max:125',
                'company_team_location' => 'required|string',
                'short_problem_description' => 'required|string',
                'detailed_description' => 'required|string',
                'applied_to_accelerator' => 'required|string',
                'If_Yes_please_indicate_ALL_the_PREVIOUS_places' => 'nullable|string',
                'previous_accelerator_places' => 'nullable|string',
                'funding_received' => 'required|array',
                'amount_funding_raised' => 'required|string',
                'revenue_generated' => 'required|string',
                'covid_impact' => 'required|string',
                'reason_for_applying' => 'required|string',
                'biggest_challenge' => 'required|string',
                'how_did_you_hear_about_us' => 'required|array',
                'race_ethnicity' => 'nullable|array',
                'gender' => 'nullable|array',
                'team_identifiers' => 'nullable|array',
                'additional_demographics' => 'nullable|string',
            ]);

            // Add applicant_id and cohort_id to round1Data
            $round1Data['applicant_id'] = $applicant->id;
            $round1Data['cohort_id'] = $lastCohort->id;

            // Convert arrays to comma-separated strings
            $round1Data['how_did_you_hear_about_us'] = isset($round1Data['how_did_you_hear_about_us']) ? implode(',', $round1Data['how_did_you_hear_about_us']) : null;
            $round1Data['funding_received'] = isset($round1Data['funding_received']) ? implode(',', $round1Data['funding_received']) : null;
            $round1Data['race_ethnicity'] = isset($round1Data['race_ethnicity']) ? implode(',', $round1Data['race_ethnicity']) : null;
            $round1Data['gender'] = isset($round1Data['gender']) ? implode(',', $round1Data['gender']) : null;
            $round1Data['team_identifiers'] = isset($round1Data['team_identifiers']) ? implode(',', $round1Data['team_identifiers']) : null;

            Log::info('Round1 Data:', $round1Data);

            // Create a new round1 entry
            $round1 = Round1::create($round1Data);
            Log::info('Round1 created:', ['round1_id' => $round1->id]);

            return response()->json(['applicant' => $applicant, 'round1' => $round1], 201);
        } catch (\Exception $e) {
            Log::error('Error saving data:', ['message' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
            return response()->json(['message' => 'Error saving data'], 500);
        }
    }

    public function show($id)
    {
        Log::info('Fetching Round1 data for ' . $id);

        // Retrieve the round1 entry by id including related applicant data
        $round1 = Round1::with('applicant')->findOrFail($id);

        return response()->json($round1);
    }

    public function update(Request $request, $round1Id)
{
    try {
        // Find the applicant and round1 instances
        
                $round1 = Round1::findOrFail($round1Id);
                $applicant = $round1->applicant;

        // Validate data for both tables
        $validatedApplicantData = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:applicants,email,' . $applicant->id,
            'company_name' => 'required|string|max:255',
        ]);

        $validatedRound1Data = $request->validate([
            'company_website' => 'nullable|url|max:255',
            'company_zip_code' => 'required|string|max:20',
            'year_company_founded' => 'nullable|integer',
            'number_of_founding_team_members' => 'required|integer',
            'current_product_stage' => 'required|string|max:255',
            'current_business_stage' => 'required|string|max:255',
            'company_formed' => 'required|string|max:255',
            'one_sentence_description' => 'required|string|max:125',
            'company_team_location' => 'required|string|max:255',
            'short_problem_description' => 'required|string|max:255',
            'detailed_description' => 'required|string|max:65535',
            'applied_to_accelerator' => 'required|string|max:255',
            'If_“Yes”_please_indicate_ALL_the_PREVIOUS_places' => 'nullable|string|max:255',
            'previous_accelerator_places' => 'nullable|string|max:255',
            'funding_received' => 'required|array',
            'amount_funding_raised' => 'required|string|max:255',
            'revenue_generated' => 'required|string|max:255',
            'covid_impact' => 'required|string|max:255',
            'reason_for_applying' => 'required|string|max:255',
            'biggest_challenge' => 'required|string|max:255',
            'how_did_you_hear_about_us' => 'required|array',
            'race_ethnicity' => 'nullable|array',
            'gender' => 'nullable|array',
            'team_identifiers' => 'nullable|array',
            'additional_demographics' => 'nullable|string|max:65535',
        ]);

        // Convert arrays to comma-separated strings
        $validatedRound1Data['how_did_you_hear_about_us'] = isset($validatedRound1Data['how_did_you_hear_about_us']) ? implode(',', $validatedRound1Data['how_did_you_hear_about_us']) : null;
        $validatedRound1Data['funding_received'] = isset($validatedRound1Data['funding_received']) ? implode(',', $validatedRound1Data['funding_received']) : null;
        $validatedRound1Data['race_ethnicity'] = isset($validatedRound1Data['race_ethnicity']) ? implode(',', $validatedRound1Data['race_ethnicity']) : null;
        $validatedRound1Data['gender'] = isset($validatedRound1Data['gender']) ? implode(',', $validatedRound1Data['gender']) : null;
        $validatedRound1Data['team_identifiers'] = isset($validatedRound1Data['team_identifiers']) ? implode(',', $validatedRound1Data['team_identifiers']) : null;

        // Log data to be updated
        Log::info('Updating Applicant:', $validatedApplicantData);
        Log::info('Updating Round1:', $validatedRound1Data);       
        $applicant->update($validatedApplicantData);
        $round1->update($validatedRound1Data);
        return response()->json([
            'message' => 'Applicant and associated Round1 updated successfully',
            'applicant' => $applicant,
            'round1' => $round1,
        ], 200);
    } catch (\Exception $e) {
        Log::error('Error updating data:', ['message' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
        return response()->json(['message' => 'Error updating data'], 500);
    }
}

    public function destroy($id)
    {
        // Find the round1 entry by id
        $round1 = Round1::findOrFail($id);

        // Delete the round1 entry
        $round1->delete();

        return response()->json(null, 204);
    }
}


//     public function manageCohort($id)
// {
//     // Store the cohort_id in the session
//     session(['cohort_id' => $id]);

//     // Redirect to the cohort management page
//    return redirect()->route('api/cohorts', ['id' => $id]);
// }