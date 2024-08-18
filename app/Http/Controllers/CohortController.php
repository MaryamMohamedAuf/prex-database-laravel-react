<?php

namespace App\Http\Controllers;

use App\Http\Requests\CohortRequest;
use App\Models\Cohort;
use App\Services\CohortService;

class CohortController extends Controller
{
    protected $cohortService;

    /**
     * Create a new controller instance.
     */
    public function __construct(CohortService $cohortService)
    {
        $this->cohortService = $cohortService;
    }

    /**
     * Display a listing of the cohorts.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $cohorts = $this->cohortService->getAllCohorts();

        return response()->json($cohorts);
    }

    /**
     * Store a newly created cohort in storage.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(CohortRequest $request)
    {
        $cohort = $this->cohortService->createCohort($request->validated());

        return response()->json([
            'message' => 'Cohort created successfully',
            'cohort' => $cohort,
        ], 201);
    }

    /**
     * Display the specified cohort.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(int $id)
    {
        $cohort = $this->cohortService->getCohortById($id);

        return response()->json($cohort);
    }

    /**
     * Show the form for editing the specified cohort.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    // public function edit(int $id)
    // {
    //     $cohort = $this->cohortService->getCohortById($id);
    //     return response()->json($cohort);
    // }

    /**
     * Update the specified cohort in storage.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(CohortRequest $request, int $id)
    {
        $cohort = $this->cohortService->updateCohort($id, $request->validated());

        return response()->json([
            'message' => 'Cohort updated successfully',
            'cohort' => $cohort,
        ], 200);
    }

    /**
     * Remove the specified cohort from storage.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(int $id)
    {
        $this->cohortService->deleteCohort($id);

        return response()->json([
            'message' => 'Cohort deleted successfully',
        ], 200);
    }
}
