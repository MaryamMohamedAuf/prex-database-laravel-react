<?php

namespace App\Http\Controllers;

use App\Http\Requests\Round3Request;
use App\Services\Round3Service;
use Illuminate\Support\Facades\Log;

class Round3Controller extends Controller
{
    protected $round3Service;

    public function __construct(Round3Service $round3Service)
    {
        $this->round3Service = $round3Service;
    }

    public function getByCohort($cohortId)
    {
        $cohortId = (int) $cohortId;
        $round3s = $this->round3Service->getByCohort($cohortId);

        return response()->json($round3s);
    }

    public function index()
    {
        $round3s = $this->round3Service->getAllRound3s();

        return response()->json($round3s);
    }

    /**
     * Show the form to create a new Round3 entry.
     *
     * @return \Illuminate\View\View
     */

    /**
     * Store a newly created Round3 resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Round3Request $request)
    {
        try {
            Log::info('Request data:', $request->all());

            // Create a new Round3 entry
            $round3 = $this->round3Service->createRound3($request->validated());

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
        $round3 = $this->round3Service->getRound3ById($id);

        return response()->json($round3);
    }

    /**
     * Update the specified Round3 resource in storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Round3Request $request, $id)
    {
        try {
            // Update the Round3 entry
            $round3 = $this->round3Service->updateRound3($id, $request->validated());

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
        try {
            $deleted = $this->round3Service->deleteRound3($id);

            if ($deleted) {
                return response()->json(null, 204);
            } else {
                return response()->json(['message' => 'Error deleting data'], 500);
            }
        } catch (\Exception $e) {
            Log::error('Error deleting data:', ['message' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);

            return response()->json(['message' => 'Error deleting data'], 500);
        }
    }
}
