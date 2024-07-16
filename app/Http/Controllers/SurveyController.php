<?php
namespace App\Http\Controllers;

use App\Models\Survey;
use Illuminate\Http\Request;

class SurveyController extends Controller
{
    /**
     * Display a listing of the surveys.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $surveys = Survey::all();
        return response()->json([
            'surveys' => $surveys,
        ], 200);
    }

    /**
     * Store a newly created survey in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'ApplicantName' => 'required|string',
            'CohortTag' => 'required|string',
        ]);

        $survey = Survey::create($validatedData);

        return response()->json([
            'message' => 'Survey created successfully',
            'survey' => $survey,
        ], 201);
    }

    /**
     * Display the specified survey.
     *
     * @param  \App\Models\Survey  $survey
     * @return \Illuminate\Http\Response
     */
    public function show(Survey $survey)
    {
        return response()->json([
            'survey' => $survey,
        ], 200);
    }

    /**
     * Update the specified survey in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Survey  $survey
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Survey $survey)
    {
        $validatedData = $request->validate([
            'ApplicantName' => 'required|string',
            'CohortTag' => 'required|string',
        ]);

        $survey->update($validatedData);

        return response()->json([
            'message' => 'Survey updated successfully',
            'survey' => $survey,
        ], 200);
    }

    /**
     * Remove the specified survey from storage.
     *
     * @param  \App\Models\Survey  $survey
     * @return \Illuminate\Http\Response
     */
    public function destroy(Survey $survey)
    {
        $survey->delete();

        return response()->json([
            'message' => 'Survey deleted successfully',
        ], 200);
    }
}
