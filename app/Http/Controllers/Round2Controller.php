<?php

namespace App\Http\Controllers;

use App\Http\Requests\ApplicantRequest;
use App\Http\Requests\Round2Request;
use App\Services\ApplicantService;
use App\Services\Round2Service;
use Illuminate\Support\Facades\Log;
use App\Models\Applicant;

class Round2Controller extends Controller
{
    protected $round2Service;

    protected $applicantService;

    public function __construct(Round2Service $round2Service, ApplicantService $applicantService)
    {
        $this->round2Service = $round2Service;
        $this->applicantService = $applicantService;
    }

    public function getByCohort($cohortId)
    {
        $round2s = $this->round2Service->getByCohort($cohortId);

        return response()->json($round2s);
    }

    public function index($cohortId)
    {
        $round2s = $this->round2Service->getAllRound2s($cohortId);

        return response()->json($round2s);
    }

    public function store(ApplicantRequest $applicantRequest, Round2Request $round2Request)
    {
        Log::info('Applicant Request Data:', $applicantRequest->all());

        // Validate the ApplicantRequest data and create the Applicant
        $applicantData = $applicantRequest->validated();

        $applicant = Applicant::whereHas('round1', function ($query) use ($applicantData) {
            $query->where('company_name', $applicantData['company_name']);
        })->first();

        if (!$applicant) {
            // Return an error message if the applicant has not applied to Round 1
            return response()->json(['message' => 'Company name must be the same you entered in Round 1. If you did not apply to Round 1, please fill out its form first.'], 400);
        }
      //  $applicant = $this->applicantService->createApplicant($validatedApplicantData);


        // Pass the applicant_id and cohort_id to Round2Request
        $round2Data = $round2Request->validated();
        $round2Data['applicant_id'] = $applicant->id;
        $round2Data['cohort_id'] = $applicant->cohort_id;

        // Convert arrays to comma-separated strings
        $round2Data['funding_received'] = isset($round2Data['funding_received']) ? implode(',', $round2Data['funding_received']) : null;
        $round2Data['sources_of_funding'] = isset($round2Data['sources_of_funding']) ? implode(',', $round2Data['sources_of_funding']) : null;
        $round2Data['accomplish_within_year'] = isset($round2Data['accomplish_within_year']) ? implode(',', $round2Data['accomplish_within_year']) : null;
        $round2Data['covid19_impact'] = isset($round2Data['covid19_impact']) ? implode(',', $round2Data['covid19_impact']) : null;
        $round2Data['critical_support_resource'] = isset($round2Data['critical_support_resource']) ? implode(',', $round2Data['critical_support_resource']) : null;
        $round2Data['best_support_resource'] = isset($round2Data['best_support_resource']) ? implode(',', $round2Data['best_support_resource']) : null;
        $round2Data['race_ethnicity'] = isset($round2Data['race_ethnicity']) ? implode(',', $round2Data['race_ethnicity']) : null;
        $round2Data['gender'] = isset($round2Data['gender']) ? implode(',', $round2Data['gender']) : null;
        $round2Data['team_identifiers'] = isset($round2Data['team_identifiers']) ? implode(',', $round2Data['team_identifiers']) : null;

        Log::info('Round2 Data:', $round2Data);

        // Create the Round2 entry
        $round2 = $this->round2Service->createRound2($round2Data);

        Log::info('Round2 created:', ['round2_id' => $round2->id]);

        return response()->json([
            'message' => 'Round 2 created successfully',
            'round2' => $round2,
            'applicant' => $applicant,
        ], 201);
    }

    public function show(int $id)
    {
        $round2 = $this->round2Service->getRound2ById($id);
        $applicant_id = $round2->applicant_id;
        $applicant = $this->applicantService->getApplicantById($applicant_id);
        return response()->json($round2);

        // return response()->json([
        //     'round2' => $round2,
        //     'applicant' => $applicant,
        // ], 200);
    }

    public function update(ApplicantRequest $applicantRequest, Round2Request $round2Request, int $id)
    {
        Log::info('Request Data:', $round2Request->all());

        // dd([
        //     'request' => $round2Request->all(),
        //     'id' => $id
        // ]);
        Log::info("Update method called with ID: $id");
        Log::info('Request URL: '.url()->current());
        Log::info('Request Method: '.request()->method());
        $applicant = $this->applicantService->updateApplicant($id, $applicantRequest->validated());
        $round2Data = $round2Request->validated();
        $round2Data['applicant_id'] = $applicant->id;
        $round2Data['cohort_id'] = $applicant->cohort_id;

        // Convert arrays to comma-separated strings
        $round2Data['funding_received'] = isset($round2Data['funding_received']) ? implode(',', $round2Data['funding_received']) : null;
        $round2Data['sources_of_funding'] = isset($round2Data['sources_of_funding']) ? implode(',', $round2Data['sources_of_funding']) : null;
        $round2Data['accomplish_within_year'] = isset($round2Data['accomplish_within_year']) ? implode(',', $round2Data['accomplish_within_year']) : null;
        $round2Data['covid19_impact'] = isset($round2Data['covid19_impact']) ? implode(',', $round2Data['covid19_impact']) : null;
        $round2Data['critical_support_resource'] = isset($round2Data['critical_support_resource']) ? implode(',', $round2Data['critical_support_resource']) : null;
        $round2Data['best_support_resource'] = isset($round2Data['best_support_resource']) ? implode(',', $round2Data['best_support_resource']) : null;
        $round2Data['race_ethnicity'] = isset($round2Data['race_ethnicity']) ? implode(',', $round2Data['race_ethnicity']) : null;
        $round2Data['gender'] = isset($round2Data['gender']) ? implode(',', $round2Data['gender']) : null;
        $round2Data['team_identifiers'] = isset($round2Data['team_identifiers']) ? implode(',', $round2Data['team_identifiers']) : null;
        Log::info($round2Data);
        $round2 = $this->round2Service->updateRound2($id, $round2Data);

        Log::info('Applicant: ', $applicant->toArray());
        Log::info('Round2: ', $round2->toArray());

        return response()->json([
            'message' => 'Round 2 updated successfully',
            'round2' => $round2,
            'applicant' => $applicant,
        ], 200);
    }

    public function destroy(int $id)
    {
        $this->round2Service->deleteRound2($id);

        return response()->json([
            'message' => 'Round 2 deleted successfully',
        ], 200);
    }
}
