<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Applicant; // Assuming you're storing the data in the Applicant model

class GoogleFormController extends Controller
{
    public function handleResponse(Request $request)
    {
        // Validate the incoming request
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:255',
            // Add other fields as necessary
        ]);

        // Create a new applicant with the data
        $applicant = Applicant::create([
            'name' => $request->input('name'),
            'phone' => $request->input('phone'),
            // Add other fields as necessary
        ]);

        return response()->json(['message' => 'Form data saved successfully', 'data' => $applicant], 201);
    }
}
