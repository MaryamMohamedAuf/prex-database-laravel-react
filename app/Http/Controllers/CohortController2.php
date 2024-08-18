<?php
namespace App\Http\Controllers;

use App\Services\CohortClient;
use Illuminate\Support\Facades\Http;

class CohortController2 extends Controller
{
    protected $cohortClient;

    // public function __construct(CohortClient $cohortClient)
    // {
       // $this->cohortClient = $cohortClient;
    //}

    public function index()
    {
        try {
            $response = Http::get("http://localhost:8001/cohorts");
            // Check if the request was successful
            if ($response->successful()) {
                return response()->json($response->json());
            }
            // Handle client or server error responses
            return response()->json(['error' => 'Failed to fetch cohorts', 'details' => $response->body()], $response->status());
        } catch (\Exception $e) {
            // Handle connection errors, timeouts, etc.
            return response()->json(['error' => 'Service unavailable', 'message' => $e->getMessage()], 503);
        }
    
    }
}
