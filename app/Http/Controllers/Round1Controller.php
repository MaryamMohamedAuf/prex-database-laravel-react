<?php

namespace App\Http\Controllers;

use App\Models\Applicant;
use App\Models\Round1;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\log;

class Round1Controller extends Controller
{
    public function index()
    {
        // Retrieve all round1 entries with associated applicant data
        $round1s = Round1::with('applicant')->get();

        return response()->json($round1s);
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
            'applied_to_accelerator?' => 'required|string',
            'If_“Yes”_please_indicate_ALL_the_PREVIOUS_places'=>'nullable|string',

            'previous_accelerator_places' => 'nullable|string',

            'funding_received' => 'required|array',

            'amount_funding_raised' => 'required|string',
            'revenue_generated' => 'required|string',
            'covid_impact' => 'required|string',
            'reason_for_applying' => 'required|string',
            'biggest_challenge' => 'required|string',

            'how_did_you_hear_about_us' => 'required|array',
            //'how_did_you_hear.*' => 'string',
            'race_ethnicity' => 'nullable|array',
            'gender' => 'nullable|array',
            'team_identifiers'=>'nullable|array',
            'additional_demographics' => 'nullable|string',
        ]);
   // 'how_did_you_hear' => json_encode($request->input('how_did_you_hear')),

        // Add applicant_id to round1Data
        $round1Data['applicant_id'] = $applicant->id;
       $round1Data ['how_did_you_hear_about_us'] = implode(',', $request->input('how_did_you_hear_about_us', []));
       $round1Data['funding_received'] = implode(',', $request->input('funding_received', []));
       $round1Data['race_ethnicity'] = implode(',', $request->input('race_ethnicity', []));
       $round1Data['gender'] = implode(',', $request->input('gender', []));
       $round1Data['team_identifiers'] = implode(',', $request->input('team_identifiers', []));
   

    
        // Create a new round1 entry
        $round1 = Round1::create($round1Data);

        return response()->json([
            'applicant' => $applicant,
            'round1' => $round1,
        ], 201);
    }

    public function create()
    {
        //
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // Retrieve the round1 entry by id including related applicant data
        $round1 = Round1::with('applicant')->findOrFail($id);

        return response()->json($round1);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Applicant $applicant, Round1 $round1)
{
    // Validate data for both tables
    $validatedApplicantData = $request->validate([
        'first_name' => 'required|string',
        'last_name' => 'required|string',
        'email' => 'required|email|unique:applicants,email,' . $applicant->id,
        'company_name' => 'required|string',
    ]);

    $validatedRound1Data = $request->validate([
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
        'applied_to_accelerator?' => 'required|string',
        'If_“Yes”_please_indicate_ALL_the_PREVIOUS_places' => 'nullable|string',
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
    $applicant = Applicant::find($round1->applicant_id);

    // Update the main Applicant data
    $applicant->update($validatedApplicantData);

    // Update the Round1 data
    $round1->update($validatedRound1Data);

    return response()->json([
        'message' => 'Applicant and associated Round1 updated successfully',
        'applicant' => $applicant,
        'round1' => $round1,
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
        // Find the round1 entry by id
        $round1 = Round1::findOrFail($id);

        // Delete the round1 entry
        $round1->delete();

        return response()->json(null, 204);
    }
}
