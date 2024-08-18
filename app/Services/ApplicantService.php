<?php

namespace App\Services;
use App\Models\Applicant;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;


use App\http\Requests\FilterApplicantRequest;
class ApplicantService
{
    /**
     * Create a new applicant.
     */
    public function createApplicant(array $data): Applicant
    {
        return Applicant::create($data);
    }

    /**
     * Retrieve an applicant by its ID.
     */
    public function getApplicantById(int $id): Applicant
    {
        // The -> operator is used to access methods and properties of an instance (object) of a class.
        return Applicant::with(['round1', 'round2', 'round3'])->findOrFail($id);
    }

    /**
     * Update an existing applicant.
     */
    public function updateApplicant(int $id, array $data): Applicant
    {
        $applicant = $this->getApplicantById($id);
        $applicant->update($data);

        return $applicant;
    }

    /**
     * Delete an applicant by its ID.
     */
    public function deleteApplicant(int $id): bool
    {
        $applicant = $this->getApplicantById($id);

        return $applicant->delete();
    }

    /**
     * Retrieve all applicants.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getAllApplicants()
    {
        
        //return Applicant::with(['round1', 'round2', 'round3'])->get();
        return Applicant::all();
    }



//search
    protected function applySearch($query, $search)
    {
        // Get all searchable columns from related tables
        $searchableColumns = array_merge(
            $this->getAllColumns('applicants'),
            $this->getAllColumns('round1s'),
            $this->getAllColumns('round2s'),
            $this->getAllColumns('round3s')
        );
    
        $query->where(function ($q) use ($search, $searchableColumns) {
            foreach ($searchableColumns as $column) {
                $q->orWhere($column, 'like', "%{$search}%");
            }
        });
    
        return $query;
    }
    
    protected function getAllColumns(string $table): array
{
    // Get all columns from the specified table
    return Schema::getColumnListing($table);
}




public function filterApplicants0(array $filters, string $searchTerm = null)
{
    $query = Applicant::query();

    // Join the applicants table with the rounds tables
    $query->with('round1', 'round2', 'round3');

    // Add search functionality
    if ($searchTerm) {
        $columns = Schema::getColumnListing('applicants'); // Get all columns from the applicants table
        $roundColumns = [
            'round1s' => Schema::getColumnListing('round1s'),
            'round2s' => Schema::getColumnListing('round2s'),
            'round3s' => Schema::getColumnListing('round3s'),
        ];

        $query->where(function ($q) use ($searchTerm, $columns, $roundColumns) {
            foreach ($columns as $column) {
                $q->orWhere($column, 'like', '%' . $searchTerm . '%');
            }

            foreach ($roundColumns as $round => $columns) {
                foreach ($columns as $column) {
                    $q->orWhere($round . '.' . $column, 'like', '%' . $searchTerm . '%');
                }
            }
        });
    }

    // Apply other filters
    foreach ($filters as $filter => $value) {
        if ($filter !== 'search') {
            $query->where($filter, '=', $value);
        }
    }

    // Return the filtered applicants
    return $query->get();

}
//     $query: This is a variable that will store the query being built to fetch applicants from the database.

// Applicant::with([...]):

// Applicant: This refers to the Applicant model. The model represents a database table, typically with the same name as the model in lowercase (e.g., applicants table).
// ::: This is the scope resolution operator, used to call a static method or property from a class.
// with([...]): This method is used to eager load relationships. It ensures that the related data from the round1, round2, and round3 models is fetched in the same query as the applicants. This reduces the number of database queries, improving performance.
//     

public function filterApplicants(array $filters)
{
    $query = Applicant::query();
   
    $query->with(['round1', 'round2', 'round3'])->get();
    if (empty($filters)) {
        return $query->with(['round1', 'round2', 'round3'])->get();
    }

    foreach ($filters as $filter => $value) {
        if (!empty($value)) {
            $relation = $this->getRelationForFilter($filter);
            $query->whereHas($relation, function ($q) use ($filter, $value) {
                $q->whereIn($filter, (array) $value);
            });
        }
    }
    
    if ($query->exists()) {
        Log::info($query->toSql());
        Log::info($query->getBindings());

        return $query->with(['round1', 'round2', 'round3'])->get();
    } else {
        return response()->json(['message' => 'No applicants found by these filters'], 404);
    }
}

protected function getRelationForFilter(string $filter): string
{
    $round1Attributes = Schema::getColumnListing('round1s');
    $round2Attributes = Schema::getColumnListing('round2s');
    $round3Attributes = Schema::getColumnListing('round3s');
    $applicantAttributes = Schema::getColumnListing('applicants');

    if (in_array($filter, $round1Attributes)) {
        return 'round1';
    } elseif (in_array($filter, $round2Attributes)) {
        return 'round2';
    } elseif (in_array($filter, $round3Attributes)) {
        return 'round3';
    } elseif (in_array($filter, $applicantAttributes)) {
        return 'applicant';
    } else {
        throw new \Exception("Filter '$filter' does not match any known attributes.");
    }
}

public function getFilterOptions()
{
    $tables = ['round1s', 'round2s', 'round3s', 'applicants'];
    $filterOptions = [];

    foreach ($tables as $table) {
        $columns = Schema::getColumnListing($table);
        foreach ($columns as $column) {
            // For simplicity, assuming each column can be a filter
            // Implement logic to fetch possible values for each column
            $filterOptions[$column] = $this->getColumnValues($table, $column);
        }
    }

    return response()->json($filterOptions);
}

protected function getColumnValues($table, $column)
{
    return DB::table($table)->distinct()->pluck($column)->toArray();
}       
    
}
