<?php
namespace App\Http\Controllers;

use App\Models\Applicant;
use Illuminate\Http\Request;

class ApplicantController extends Controller
{
   // app/Http/Controllers/ApplicantController.php
public function getApplicantDetails($id)
{
    try {
        $applicant = Applicant::with('round1', 'round2', 'round3')->find($id);
        return response()->json($applicant);
    } catch (\Exception $e) {
        return response()->json(['message' => 'Error fetching applicant details'], 500);
    }
}

    public function index()
    {
        $applicants = Applicant::all();
        return response()->json($applicants);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'first_name' => 'required|string|max:255',
            'cohort_id' => 'required|exists:cohorts,id',

            'last_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:applicants',
            'company_name' => 'required|string|max:255',
        ]);

        $applicant = Applicant::create($validatedData);

        return response()->json($applicant, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Applicant $applicant)
    {
        return response()->json($applicant);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Applicant $applicant)
    {
        $validatedData = $request->validate([
            'first_name' => 'sometimes|required|string|max:255',
            'cohort_id' => 'required|exists:cohorts,id',

            'last_name' => 'sometimes|required|string|max:255',
            'email' => 'sometimes|required|string|email|max:255|unique:applicants,email,' . $applicant->id,
            'company_name' => 'sometimes|required|string|max:255',
        ]);

        $applicant->update($validatedData);

        return response()->json($applicant);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Applicant $applicant)
    {
        $applicant->delete();

        return response()->json(null, 204);
    }
}
