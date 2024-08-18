<?php

namespace App\Http\Requests;

use App\Models\Cohort;
use Illuminate\Foundation\Http\FormRequest;

class Round3Request extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation()
    {
        // Get the latest cohort
        $lastCohort = Cohort::latest('id')->first();

        // If no cohort is found, you may want to handle this, perhaps by throwing an exception.
        if (! $lastCohort) {
            abort(400, 'No cohort found');
        }

        // Merge the cohort_id into the request data
        $this->merge([
            'cohort_id' => $lastCohort->id,
        ]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'applicant_id' => 'required|exists:applicants,id',
            'cohort_id' => 'required|exists:cohorts,id',
            'final_decision' => 'required|boolean',
            'recorded_meeting_link' => 'nullable|string',
        ];
    }
}
