<?php

namespace App\Http\Controllers;

use App\Models\Applicant;
use App\Models\Cohort;
use App\Models\Round3;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class Round3Controller extends Controller
{
   
    public function index()
    {
        // Retrieve all Round3 entries with associated applicant and cohort data
        $round3s = Round3::with(['applicant', 'cohort'])->get();

        return response()->json($round3s);
    }

    /**
     * Show the form to create a new Round3 entry.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        // Get the list of applicants from Round2
        $applicants = Applicant::whereHas('round2')->orderBy('last_name')->get();
        $cohorts = Cohort::orderBy('name')->get();

        return view('round3.create', compact('applicants', 'cohorts'));
    }

    /**
     * Store a newly created Round3 resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            Log::info('Request data:', $request->all());

            // Validate the incoming request data
            $validatedData = $request->validate([
                'applicant_id' => 'required|exists:applicants,id',
              //  'cohort_id' => 'required|exists:cohorts,id',
                'final_decision' => 'required|boolean',
                'recorded_meeting_link' => 'nullable|string',
            ]);

            $lastCohort = Cohort::latest('id')->first();
            if (!$lastCohort) {
                return response()->json(['message' => 'No cohort found'], 400);
            }

            $validatedData['cohort_id'] = $lastCohort->id;
            // Create a new Round3 entry
            $round3 = Round3::create($validatedData);

            return response()->json(['round3' => $round3], 201);
        } catch (\Exception $e) {
            Log::error('Error saving data:', ['message' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
            return response()->json(['message' => 'Error saving data'], 500);
        }
    }

    /**
     * Display the specified Round3 resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $round3 = Round3::with(['applicant', 'cohort'])->findOrFail($id);

        return response()->json($round3);
    }

    /**
     * Show the form to edit the specified Round3 resource.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        $round3 = Round3::findOrFail($id);
        $applicants = Applicant::whereHas('round2')->orderBy('last_name')->get();
        $cohorts = Cohort::orderBy('name')->get();

        return view('round3.edit', compact('round3', 'applicants', 'cohorts'));
    }

    /**
     * Update the specified Round3 resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            // Validate the incoming request data
            $validatedData = $request->validate([
                'applicant_id' => 'required|exists:applicants,id',
               // 'cohort_id' => 'required|exists:cohorts,id',
                'final_decision' => 'required|boolean',
                'recorded_meeting_link' => 'nullable|string',
            ]);
            $lastCohort = Cohort::latest('id')->first();
            if (!$lastCohort) {
                return response()->json(['message' => 'No cohort found'], 400);
            }

            $validatedData['cohort_id'] = $lastCohort->id;
            // Create a new Round3 entry
            $round3 = Round3::create($validatedData);

            // Find the Round3 entry
            $round3 = Round3::findOrFail($id);

            // Update the Round3 entry
            $round3->update($validatedData);

            return response()->json([
                'message' => 'Round 3 entry updated successfully',
                'round3' => $round3,
            ], 200);
        } catch (\Exception $e) {
            Log::error('Error updating data:', ['message' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
            return response()->json(['message' => 'Error updating data'], 500);
        }
    }

    /**
     * Remove the specified Round3 resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // Find the Round3 entry by id
        $round3 = Round3::findOrFail($id);

        // Delete the Round3 entry
        $round3->delete();

        return response()->json(null, 204);
    }
}
