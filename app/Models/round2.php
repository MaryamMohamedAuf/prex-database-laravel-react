<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class round2 extends Model
{
    use HasFactory;

    protected $fillable = [
        'applicant_id',
        'cohort_id',

        'phone',
        'One_Sentence_Description',
        'sector',
        'other_sector',
        'business_model',
        'other_business_model',
        'solution',
        'other_solution',
        'demo_url',
        'traction',
        'where_customer_find_solution',
        'revenue_generated',
        'funding_received',
        'other_funding_type',
        'sources_of_funding',
        'core_team_members',
        'previous_startup_experience',
        'core_team',
        'core_team_experience',
        'employees_full_time_part_time_interns',
        'positions_to_fill',
        'goals_next_3_to_12_months',
        'prex_program_expectations',
        'accomplish_within_year',
        'submit_pitch_video_url',
        'covid19_resilience_impact',
        'social_impact',
        'covid19_impact',
        'other_covid19_impact',
        'critical_support_resource',
        'best_support_resource',
        'holding_back_growth_reason',
        'other_comments',
        'race_ethnicity',
        'gender',
        'team_identifiers',
        'if_other_team_identifiers',
    ];

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function applicant()
    {
        return $this->belongsTo(Applicant::class);
    }

    public function cohort()
    {
        return $this->belongsTo(Cohort::class);
    }
}
