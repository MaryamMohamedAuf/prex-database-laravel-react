<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class Round1Request extends FormRequest
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
            'company_website' => 'nullable|url',
            'company_zip_code' => 'required|string',
            'year_company_founded' => 'nullable|integer',
            'number_of_founding_team_members' => 'required|integer',
            'current_product_stage' => 'required|string',
            'current_business_stage' => 'required|string',
            'company_formed' => 'required|string',
            'one_sentence_description' => 'required|string|max:125',
            'company_team_location' => 'required|string',
            'short_problem_description' => 'required|string',
            'detailed_description' => 'required|string',
            'applied_to_accelerator' => 'required|string',
            'If_Yes_please_indicate_ALL_the_PREVIOUS_places' => 'nullable|string',
            'previous_accelerator_places' => 'nullable|string',
            'funding_received' => 'required|array',
            'amount_funding_raised' => 'required|string',
            'revenue_generated' => 'required|string',
            'covid_impact' => 'required|string',
            'reason_for_applying' => 'required|string',
            'biggest_challenge' => 'required|string',
            'how_did_you_hear_about_us' => 'required|array',
            'race_ethnicity' => 'nullable|array',
            'gender' => 'nullable|array',
            'team_identifiers' => 'nullable|array',
            'additional_demographics' => 'nullable|string',
        ];
    }
}
