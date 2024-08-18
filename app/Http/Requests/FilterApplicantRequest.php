<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FilterApplicantRequest extends FormRequest
{
    public function authorize()
    {
        return true; // Update based on your authorization needs
    }

    public function rules()
    {
        return [
            'first_name' => 'nullable|string|max:255',
            'last_name' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'company_name' => 'nullable|string|max:255',
            'cohort_id' => 'nullable|exists:cohorts,id',
            'company_website' => 'nullable|url',
            'company_zip_code' => 'nullable|string',
            'year_company_founded' => 'nullable|integer',
            'number_of_founding_team_members' => 'nullable|integer',
            'current_product_stage' => 'nullable|string',
            'current_business_stage' => 'nullable|string',
            'company_formed' => 'nullable|string',
            'one_sentence_description' => 'nullable|string|max:125',
            'company_team_location' => 'nullable|string',
            'short_problem_description' => 'nullable|string',
            'detailed_description' => 'nullable|string',
            'applied_to_accelerator' => 'nullable|string',
            'If_Yes_please_indicate_ALL_the_PREVIOUS_places' => 'nullable|string',
            'previous_accelerator_places' => 'nullable|string',
            'funding_received' => 'nullable|array',
            'amount_funding_raised' => 'nullable|string',
            'revenue_generated' => 'nullable|string',
            'covid_impact' => 'nullable|string',
            'reason_for_applying' => 'nullable|string',
            'biggest_challenge' => 'nullable|string',
            'how_did_you_hear_about_us' => 'nullable|array',
            'race_ethnicity' => 'nullable|array',
            'gender' => 'nullable|array',
            'team_identifiers' => 'nullable|array',
            'additional_demographics' => 'nullable|string',
            'phone' => 'nullable|string',
            'One_Sentence_Description' => 'nullable|string|max:125',
            'sector' => 'nullable|string',
            'other_sector' => 'nullable|string',
            'business_model' => 'nullable|string',
            'other_business_model' => 'nullable|string',
            'solution' => 'nullable|string',
            'other_solution' => 'nullable|string',
            'demo_url' => 'nullable|string',
            'traction' => 'nullable|string',
            'where_customer_find_solution' => 'nullable|string',
            'revenue_generated' => 'nullable|string',
            'other_funding_type' => 'nullable|string',
            'sources_of_funding' => 'nullable|array',
            'core_team_members' => 'nullable|integer',
            'previous_startup_experience' => 'nullable|boolean',
            'core_team' => 'nullable|string',
            'core_team_experience' => 'nullable|string',
            'employees_full_time_part_time_interns' => 'nullable|string',
            'positions_to_fill' => 'nullable|string',
            'goals_next_3_to_12_months' => 'nullable|string',
            'prex_program_expectations' => 'nullable|string',
            'accomplish_within_year' => 'nullable|array',
            'submit_pitch_video_url' => 'nullable|string',
            'covid19_resilience_impact' => 'nullable|string',
            'social_impact' => 'nullable|string',
            'covid19_impact' => 'nullable|array',
            'other_covid19_impact' => 'nullable|string',
            'critical_support_resource' => 'nullable|array',
            'best_support_resource' => 'nullable|array',
            'holding_back_growth_reason' => 'nullable|string',
            'other_comments' => 'nullable|string',
            'if_other_team_identifiers' => 'nullable|string',
            'applicant_id' => 'nullable|exists:applicants,id',
            'final_decision' => 'nullable|boolean',
            'recorded_meeting_link' => 'nullable|string',
        ];
    }
}
