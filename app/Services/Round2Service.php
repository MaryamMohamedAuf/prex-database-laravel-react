<?php

namespace App\Services;

use App\Models\Round2;
use App\Models\Applicant;

class Round2Service
{
    /**
     * Create a new Round 2 record.
     */
    public function createRound2(array $data): Round2
    {
      
        return Round2::create($data);
    }

    /**
     * Retrieve a Round 2 record by its ID.
     */
    public function getRound2ById(int $id): Round2
    {
        return Round2::with('applicant')
        ->findOrFail($id);
    }

    /**
     * Update an existing Round 2 record.
     */
    public function updateRound2(int $id, array $data): Round2
    {
        $round2 = $this->getRound2ById($id);
        $round2->update($data);

        return $round2;
    }

    /**
     * Delete a Round 2 record by its ID.
     */
    public function deleteRound2(int $id): bool
    {
        $round2 = $this->getRound2ById($id);

        return $round2->delete();
    }

    /**
     * Retrieve all Round 2 records.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getAllRound2s()
    {
        return Round2::all();
    }

    /**
     * Retrieve Round 2 records by cohort ID.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getByCohort(int $cohortId)
    {
        return Round2::with('applicant')->where('cohort_id', $cohortId)->get();
    }
}
