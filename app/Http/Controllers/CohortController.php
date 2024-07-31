<?php
namespace App\Http\Controllers;

use App\Models\Cohort;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\log;

use Inertia\Inertia;

class CohortController extends Controller
{
    
    public function index()
    {
        $user = auth()->user();
        $cohorts = Cohort::all();
      // return Inertia::render('cohorts/index', ['cohorts' => $cohorts]);
       return response()->json($cohorts);
    }

    public function create()
     {
       return Inertia::render('cohorts/create');
    
     }
     
    public function store(Request $request)
    {
        $user = auth()->user();
        $validatedData = $request->validate([
            'number' => 'required|integer',
            'start_date' => 'required|date',
            'end_date' => 'required|date',
        ]);
    
        $cohort = Cohort::create($validatedData);

        /////////////
        $cohort = Cohort::find(1);
$round2s = $cohort->round2s;

foreach ($round2s as $round2) {
    echo $round2->some_attribute;
}
////////////////////
    
       // return redirect()->route('cohorts.index')->with('success', 'Cohort created successfully.');
           // $cohort = Cohort::create($request->all());
    
        return response()->json([
            'message' => 'Cohort created successfully',
            'cohort' => $cohort
        ], 201);
    }
    
    public function show($id)
    {
        $cohort = Cohort::with(['applicants', 'onboardingSurveys', 'followupSurveys', 'round1s', 'round2s', 'round3s'])->findOrFail($id);
        return response()->json($cohort);
    }

    public function edit($id)
    {
        $cohort = Cohort::findOrFail($id);
        return response()->json($cohort);
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'number' => 'required|integer',
            'start_date' => 'required|date',
            'end_date' => 'required|date',
        ]);

        $cohort = Cohort::findOrFail($id);
        $cohort->update($validatedData);

        return response()->json([
            'message' => 'Cohort updated successfully',
            'cohort' => $cohort
        ], 200);
    }

    public function destroy($id)
    {
        $cohort = Cohort::findOrFail($id);
        $cohort->delete();

        return response()->json([
            'message' => 'Cohort deleted successfully'
        ], 200);
    }
}
