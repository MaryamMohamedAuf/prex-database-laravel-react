<?php

namespace App\Http\Controllers;

use App\Models\Applicant;
use App\Models\Round2;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class Round2Controller extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Retrieve all Round2 entries with associated Applicant data
        $round2s = Round2::with('applicant')->get();

        return response()->json($round2s);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Log::info('Request data:', $request->all());

        // Validate request data for applicants table
        $applicantData = $request->validate([
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'email' => 'required|email|unique:applicants,email',
            'company_name' => 'required|string',
        ]);

        // Create an applicant entry
        $applicant = Applicant::create($applicantData);

        // Validate request data for round2s table
        $round2Data = $request->validate([
            'phone' => 'nullable|string',
            'One-Sentence_Description' => 'nullable|string|max:125',
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

        // Convert array fields to comma-separated strings
        $round2Data['funding_received'] = implode(',', $request->input('funding_received', []));
        $round2Data['sources_of_funding'] = implode(',', $request->input('sources_of_funding', []));
        $round2Data['accomplish_within_year'] = implode(',', $request->input('accomplish_within_year', []));
        $round2Data['covid19_impact'] = implode(',', $request->input('covid19_impact', []));
        $round2Data['critical_support_resource'] = implode(',', $request->input('critical_support_resource', []));
        $round2Data['best_support_resource'] = implode(',', $request->input('best_support_resource', []));
    
        $round2Data['race_ethnicity'] = implode(',', $request->input('race_ethnicity', []));
        $round2Data['gender'] = implode(',', $request->input('gender', []));
        $round2Data['team_identifiers'] = implode(',', $request->input('team_identifiers', []));

        // Add applicant_id to round2Data
        $round2Data['applicant_id'] = $applicant->id;

        // Create a new Round2 entry
        $round2 = Round2::create($round2Data);

        return response()->json([
            'applicant' => $applicant,
            'round2' => $round2,
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // Retrieve the Round2 entry by id including related Applicant data
        $round2 = Round2::with('applicant')->findOrFail($id);

        return response()->json($round2);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Applicant  $applicant
     * @param  Round2  $round2
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Applicant $applicant, Round2 $round2)
    {
        // Validate data for both tables
        $validatedApplicantData = $request->validate([
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'email' => 'required|email|unique:applicants,email,' . $applicant->id,
            'company_name' => 'required|string',
        ]);

        $validatedRound2Data = $request->validate([
            'phone' => 'nullable|string',
            'One-Sentence_Description' => 'nullable|string|max:125',
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
        $applicant = Applicant::find($round2->applicant_id);

        // Update the main Applicant data
        $applicant->update($validatedApplicantData);

        // Convert array fields to comma-separated strings
        $validatedRound2Data['funding_received'] = implode(',', $request->input('funding_received', []));
        $validatedRound2Data['sources_of_funding'] = implode(',', $request->input('sources_of_funding', []));
        $validatedRound2Data['accomplish_within_year'] = implode(',', $request->input('accomplish_within_year', []));
        $validatedRound2Data['covid19_impact'] = implode(',', $request->input('covid19_impact', []));
        $validatedRound2Data['critical_support_resource'] = implode(',', $request->input('critical_support_resource', []));
        $validatedRound2Data['best_support_resource'] = implode(',', $request->input('best_support_resource', []));
    
        $validatedRound2Data['race_ethnicity'] = implode(',', $request->input('race_ethnicity', []));
        $validatedRound2Data['gender'] = implode(',', $request->input('gender', []));
        $validatedRound2Data['team_identifiers'] = implode(',', $request->input('team_identifiers', []));

        // Update the Round2 data
        $round2->update($validatedRound2Data);

        return response()->json([
            'message' => 'Applicant and associated Round2 updated successfully',
            'applicant' => $applicant,
            'round2' => $round2,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // Find the Round2 entry by id
        $round2 = Round2::findOrFail($id);

        // Delete the Round2 entry
        $round2->delete();

        return response()->json(null, 204);
    }
}
