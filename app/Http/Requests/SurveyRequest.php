<?php

namespace App\Http\Requests;

use App\Models\cohort;
use Illuminate\Foundation\Http\FormRequest;

class SurveyRequest extends FormRequest
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
    public function rules()
    {
        return [
            'applicant_name' => 'required|string|max:255',
            'company_name' => 'required|string|max:255|exists:applicants,company_name',
            'cohort_id' => 'required|integer|exists:cohorts,id',
            'cohort_tag' => 'nullable|string|max:255',
        ];
    }
}
