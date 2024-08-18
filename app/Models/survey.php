<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Survey extends Model
{
    use HasFactory;

    protected $fillable = [
        'applicant_name',
        'company_name',
        'cohort_id',
        'cohort_tag',
    ];

    public function followupSurveys()
    {
        return $this->hasMany(FollowupSurvey::class);

    }

    public function onboardingSurveys()
    {
        return $this->hasMany(OnboardingSurvey::class);

    }

    public function cohort()
    {
        return $this->belongsTo(Cohort::class);
    }
}
