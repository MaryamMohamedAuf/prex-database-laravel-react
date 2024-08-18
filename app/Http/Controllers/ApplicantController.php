<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Log;

use App\Http\Requests\applicant as RequestsApplicant;
use App\Http\Requests\ApplicantRequest;
use App\Http\Requests\Round2Request;
use App\Http\Requests\Round3Request;

use App\Http\Requests\FilterApplicantRequest;
use App\Http\Requests;
use App\Models\Applicant;
use App\Models\round2;
use App\Models\round3;
use App\Services\ApplicantService;
use Illuminate\Http\Request;

class ApplicantController extends Controller
{
    protected $applicantService;

    /**
     * Create a new controller instance.
     */
    public function __construct(ApplicantService $applicantService)
    {
        $this->applicantService = $applicantService;
    }
           // $applicants = $this->applicantService->filterApplicants($validatedFilters['filters'] ?? [], $searchTerm);

    public function filter(FilterApplicantRequest $request)
    {
        // Get validated data from the request
        $validatedFilters = $request->validated();
        $searchTerm = $validatedFilters['search'] ?? null;
    $searchTerm = $validatedFilters['search'] ?? null;

        // Use the validated data to filter applicants
        $applicants = $this->applicantService->filterApplicants($validatedFilters, $searchTerm);

        // Return the filtered applicants as JSON
        return response()->json($applicants);
    }
    public function getFilterOptions(FilterApplicantRequest $request)
    {
        $filterOptions = $this->applicantService->getFilterOptions();
        // Return the filtered applicants as JSON
        return response()->json(['original' => $filterOptions]);
    }

    
    /**
     * Display a listing of the applicants.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(ApplicantRequest $request)
{
    try {
        $validatedData = $request->validated();
        Log::info('Applicant Request Data:', $validatedData);
        $applicant = $this->applicantService->getAllApplicants($validatedData);
        return response()->json($applicant);
    } catch (\Exception $e) {
        Log::error('Error fetching applicants:', ['exception' => $e]);
        return response()->json(['error' => 'Unable to fetch applicants'], 500);
    }
}

    

    /**
     * Store a newly created applicant in storage.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(ApplicantRequest $request)
    {
        $applicant = $this->applicantService->createApplicant($request->validated());

        return response()->json([
            'message' => 'Applicant created successfully',
            'applicant' => $applicant,
        ], 201);
    }

    /**
     * Display the specified applicant.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(int $id)
    {
        $applicant = $this->applicantService->getApplicantById($id);

        return response()->json($applicant);
    }

    /**
     * Update the specified applicant in storage.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(ApplicantRequest $request, int $id)
    {
        $applicant = $this->applicantService->updateApplicant($id, $request->validated());

        return response()->json([
            'message' => 'Applicant updated successfully',
            'applicant' => $applicant,
        ], 200);
    }

    /**
     * Remove the specified applicant from storage.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(int $id)
    {
        $this->applicantService->deleteApplicant($id);

        return response()->json([
            'message' => 'Applicant deleted successfully',
        ], 200);
    }
}
