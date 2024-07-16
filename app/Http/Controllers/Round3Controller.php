<?php

namespace App\Http\Controllers;

use App\Models\Applicant;
use App\Models\Round3;
use Illuminate\Http\Request;

class Round3Controller extends Controller
{
    /**
     * Display a listing of the Round3 resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $round3s = Round3::with('applicant')->get();

        return response()->json($round3s);
    }

    /**
     * Show the form to create a new Round3 entry.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $applicants = Applicant::orderBy('last_name')->get();

        return view('round3.create', compact('applicants'));
    }

    /**
     * Store a newly created Round3 resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validate the incoming request data
        $validatedData = $request->validate([
            'applicant_id' => 'required|exists:applicants,id',
            'final_decision' => 'required|boolean',
            'recorded_meeting_link' => 'nullable|string',
        ]);

        // Create a new Round3 entry
        Round3::create($validatedData);

    }

    /**
     * Display the specified Round3 resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $round3 = Round3::findOrFail($id);

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
        $applicants = Applicant::orderBy('company_name')->get();

        return view('round3.edit', compact('round3', 'applicants'));
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
        // Validate the incoming request data
        $validatedData = $request->validate([
            'applicant_id' => 'required|exists:applicants,id',
            'final_decision' => 'required|boolean',
            'recorded_meeting_link' => 'nullable|string',
        ]);

        // Find the Round3 entry
        $round3 = Round3::findOrFail($id);

        // Update the Round3 entry
        $round3->update($validatedData);

        //return redirect()->route('round3.index')->with('success', 'Round 3 information updated successfully.');
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

