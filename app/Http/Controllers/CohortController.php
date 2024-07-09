<?php
namespace App\Http\Controllers;

use App\Models\Cohort;
use Illuminate\Http\Request;
use Illuminate\Support\str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\log;

use Inertia\Inertia;

class CohortController extends Controller
{
    public function index()
    {
        $cohorts = Cohort::all();
       return Inertia::render('cohorts/index', ['cohorts' => $cohorts]);
       return response()->json($cohorts);
    }

    public function create()
     {
       return Inertia::render('cohorts/create');
    
     }

    // public function store(Request $request)
    // {
    //     $request->validate([
    //         'number' => 'required|integer',
    //         'name' => 'required|string|max:255',
    //     ]);

        //Cohort::create($request->all());

        //return redirect()->route('cohorts.index')->with('success', 'Cohort created successfully.');
    //     $cohort = Cohort::create($request->all());

    //     return response()->json([
    //         'message' => 'Cohort created successfully',
    //         'cohort' => $cohort
    //     ], 201);
    //     dd($cohort);
    // }
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'number' => 'required|integer',
            'name' => 'required|string',
        ]);
    
        $cohort = Cohort::create($validatedData);
    
       // return redirect()->route('cohorts.index')->with('success', 'Cohort created successfully.');
           // $cohort = Cohort::create($request->all());
    
        return response()->json([
            'message' => 'Cohort created successfully',
            'cohort' => $cohort
        ], 201);
    }
    
    // Add methods for show, edit, update, and destroy as needed
}
