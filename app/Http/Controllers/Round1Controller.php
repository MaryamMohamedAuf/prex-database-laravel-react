<?php

namespace App\Http\Controllers;

use App\Events\ApplicantCreated;
use App\Http\Requests\ApplicantRequest;
use App\Http\Requests\Round1Request;
use App\Services\ApplicantService;
use App\Services\Round1Service;
use Illuminate\Support\Facades\Log;

class Round1Controller extends Controller
{
    protected $round1Service;

    protected $applicantService;

    public function __construct(Round1Service $round1Service, ApplicantService $applicantService)
    {
        $this->round1Service = $round1Service;
        $this->applicantService = $applicantService;
    }

    public function getByCohort($cohortId)
    {
        $round1s = $this->round1Service->getByCohort($cohortId);

        return response()->json($round1s);
    }

    public function index($cohortId)
    {
        $round1s = $this->round1Service->getAllRound1s($cohortId);

        return response()->json($round1s);
    }

    public function store(ApplicantRequest $applicantRequest, Round1Request $round1Request)
    {
        Log::info('Applicant Request Data:', $applicantRequest->all());
        // Validate the ApplicantRequest data and create the Applicant
        $validatedApplicantData = $applicantRequest->validated();
        $applicant = $this->applicantService->createApplicant($validatedApplicantData);
        Log::info('Applicant Request Data:', $applicantRequest->all());

        // Pass the applicant_id and cohort_id to Round1Request
        $round1Data = $round1Request->validated();
        $round1Data['applicant_id'] = $applicant->id;
        $round1Data['cohort_id'] = $applicant->cohort_id;
        // Convert arrays to comma-separated strings
        $round1Data['how_did_you_hear_about_us'] = isset($round1Data['how_did_you_hear_about_us']) ? implode(',', $round1Data['how_did_you_hear_about_us']) : null;
        $round1Data['funding_received'] = isset($round1Data['funding_received']) ? implode(',', $round1Data['funding_received']) : null;
        $round1Data['race_ethnicity'] = isset($round1Data['race_ethnicity']) ? implode(',', $round1Data['race_ethnicity']) : null;
        $round1Data['gender'] = isset($round1Data['gender']) ? implode(',', $round1Data['gender']) : null;
        $round1Data['team_identifiers'] = isset($round1Data['team_identifiers']) ? implode(',', $round1Data['team_identifiers']) : null;

        Log::info('Round1 Data:', $round1Data);

        // Create the Round1 entry
        $round1 = $this->round1Service->createRound1($round1Data);
        Log::info('Round1 created:', ['round1_id' => $round1->id]);
        event(new ApplicantCreated($applicant));

        return response()->json([
            'message' => 'Round 1 created successfully',
            'round1' => $round1,
            'applicant' => $applicant,
        ], 201);
    }

    public function show(int $id)
    {
        $round1 = $this->round1Service->getRound1ById($id);
        $applicant_id = $round1->applicant_id;
        $applicant = $this->applicantService->getApplicantById($applicant_id);
        return response()->json($round1);

        // return response()->json([
        //     'round1' => $round1,
        //     'applicant' => $applicant,
        // ], 201);
    }

    public function update(ApplicantRequest $applicantRequest, Round1Request $round1Request, int $id)
    {
        $applicant = $this->applicantService->updateApplicant($id, $applicantRequest->validated());
        $round1 = $this->round1Service->updateRound1($id, $round1Request->validated());

        return response()->json([
            'message' => 'Round 1 updated successfully',
            'round1' => $round1,
            'applicant' => $applicant,
        ], 200);
    }

    public function destroy(int $id)
    {
        $this->round1Service->deleteRound1($id);

        return response()->json([
            'message' => 'Round 1 deleted successfully',
        ], 200);
    }
}
