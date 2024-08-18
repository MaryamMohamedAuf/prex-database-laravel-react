<?php

namespace App\Services;

use App\Models\cohort;
use App\Models\Round3;
use Illuminate\Support\Facades\Log;

class Round3Service
{
    /**
     * Create a new Round 3 record.
     */
    public function createRound3(array $data): Round3
    {
        try {

            return Round3::create($data);
        } catch (\Exception $e) {
            Log::error('Error creating Round3 record:', ['message' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
            throw $e;
        }
    }

    /**
     * Retrieve a Round 3 record by its ID.
     */
    public function getRound3ById(int $id): Round3
    {
        try {
            //return Round3::findOrFail($id);
            return Round3::with('applicant')->findOrFail($id);
        } catch (\Exception $e) {
            Log::error('Error retrieving Round3 record:', ['message' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
            throw $e;
        }
    }

    /**
     * Update an existing Round 3 record.
     */
    public function updateRound3(int $id, array $data): Round3
    {
        try {
            $round3 = $this->getRound3ById($id);
            $round3->update($data);

            return $round3;
        } catch (\Exception $e) {
            Log::error('Error updating Round3 record:', ['message' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
            throw $e;
        }
    }

    /**
     * Delete a Round 3 record by its ID.
     */
    public function deleteRound3(int $id): bool
    {
        try {
            $round3 = $this->getRound3ById($id);

            return $round3->delete();
        } catch (\Exception $e) {
            Log::error('Error deleting Round3 record:', ['message' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
            throw $e;
        }
    }

    /**
     * Retrieve all Round 3 records.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getAllRound3s()
    {
        try {
            return Round3::all();
        } catch (\Exception $e) {
            Log::error('Error retrieving all Round3 records:', ['message' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
            throw $e;
        }
    }

    /**
     * Retrieve Round 3 records by cohort ID.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getByCohort(int $cohortId)
    {
        try {
            return Round3::with('applicant')->where('cohort_id', $cohortId)->get();
        } catch (\Exception $e) {
            Log::error('Error retrieving Round3 records by cohort:', ['message' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
            throw $e;
        }
    }
}
