<?php

namespace App\Services;

use App\Models\Round1;

class Round1Service
{
    /**
     * Create a new Round 1 record.
     */
    public function createRound1(array $data): Round1
    {
        return Round1::create($data);
    }

    /**
     * Retrieve a Round 1 record by its ID.
     */
    public function getRound1ById(int $id): Round1
    {
        return Round1::with('applicant')
        ->findOrFail($id);
    }

    /**
     * Update an existing Round 1 record.
     */
    public function updateRound1(int $id, array $data): Round1
    {
        $round1 = $this->getRound1ById($id);
        $round1->update($data);

        return $round1;
    }

    /**
     * Delete a Round 1 record by its ID.
     */
    public function deleteRound1(int $id): bool
    {
        $round1 = $this->getRound1ById($id);

        return $round1->delete();
    }

    /**
     * Retrieve all Round 1 records.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getAllRound1s()
    {
       
       return Round1::all();
    }

    /**
     * Retrieve Round 1 records by cohort ID.
     *
     * @param  int  $cohortId
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getByCohort($cohortId)
    {
        return Round1::with('applicant')->where('cohort_id', $cohortId)->get();

    }
}
