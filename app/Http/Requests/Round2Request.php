<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class Round2Request extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'phone' => 'nullable|string',
            'One_Sentence_Description' => 'nullable|string|max:125',
            'sector' => 'required|string',
            'other_sector' => 'nullable|string',
            'business_model' => 'required|string',
            'other_business_model' => 'nullable|string',
            'solution' => 'required|string',
            'other_solution' => 'nullable|string',
            'demo_url' => 'nullable|string',
            'traction' => 'required|string',
            'where_customer_find_solution' => 'required|string',
            'revenue_generated' => 'required|string',
            'funding_received' => 'required|array',
            'other_funding_type' => 'nullable|string',
            'sources_of_funding' => 'required|array',
            'core_team_members' => 'required|integer',
            'previous_startup_experience' => 'required|boolean',
            'core_team' => 'nullable|string',
            'core_team_experience' => 'nullable|string',
            'employees_full_time_part_time_interns' => 'required|string',
            'positions_to_fill' => 'nullable|string',
            'goals_next_3_to_12_months' => 'required|string',
            'prex_program_expectations' => 'required|string',
            'accomplish_within_year' => 'required|array',
            'submit_pitch_video_url' => 'required|string',
            'covid19_resilience_impact' => 'nullable|string',
            'social_impact' => 'required|string',
            'covid19_impact' => 'required|array',
            'other_covid19_impact' => 'nullable|string',
            'critical_support_resource' => 'required|array',
            'best_support_resource' => 'required|array',
            'holding_back_growth_reason' => 'nullable|string',
            'other_comments' => 'nullable|string',
            'race_ethnicity' => 'nullable|array',
            'gender' => 'nullable|array',
            'team_identifiers' => 'nullable|array',
            'if_other_team_identifiers' => 'nullable|string',
        ];
    }
}
