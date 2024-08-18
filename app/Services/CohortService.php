<?php

namespace App\Services;

use App\Models\Cohort;

class CohortService
{
    /**
     * Create a new cohort.
     */
    public function createCohort(array $data): Cohort
    {
        return Cohort::create($data);
    }

    /**
     * Retrieve a cohort by its ID.
     */
    public function getCohortById(int $id): Cohort
    {
        return Cohort::findOrFail($id);
    }

    /**
     * Update an existing cohort.
     */
    public function updateCohort(int $id, array $data): Cohort
    {
        $cohort = $this->getCohortById($id);
        $cohort->update($data);

        return $cohort;
    }

    /**
     * Delete a cohort by its ID.
     */
    public function deleteCohort(int $id): bool
    {
        $cohort = $this->getCohortById($id);

        return $cohort->delete();
    }

    /**
     * Retrieve all cohorts.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getAllCohorts()
    {
        return Cohort::all();
    }
}
