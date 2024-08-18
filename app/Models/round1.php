<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Round1 extends Model
{
    protected $fillable = [
        'applicant_id',
        'cohort_id',

        'company_website',
        'company_zip_code',
        'year_company_founded',
        'number_of_founding_team_members',
        'current_product_stage',
        'current_business_stage',
        'company_formed',
        'one_sentence_description',
        'company_team_location',
        'if_you_selected_other_please_specify',
        'short_problem_description',
        'detailed_description',
        'applied_to_accelerator',
        'previous_accelerator_places',
        'If_Yes_please_indicate_ALL_the_PREVIOUS_places',
        'funding_received',
        'amount_funding_raised',
        'revenue_generated',
        'covid_impact',
        'reason_for_applying',
        'biggest_challenge',
        'how_did_you_hear_about_us',
        'race_ethnicity',
        'gender',
        'additional_demographics',
        'team_identifiers',
    ];

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    /**
     * Get the applicant that owns the round1 entry.
     */
    public function applicant()
    {
        return $this->belongsTo(Applicant::class);
    }

    public function cohort()
    {
        return $this->belongsTo(Cohort::class);
    }
}
