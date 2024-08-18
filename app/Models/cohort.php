<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class cohort extends Model
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'number',
        'start_date',
        'end_date',
    ];

    public function onboardingSurveys()
    {
        return $this->hasMany(OnboardingSurvey::class);
    }

    public function followupSurveys()
    {
        return $this->hasMany(FollowupSurvey::class);
    }

    public function round1s()
    {
        // return $this->hasManyThrough(Round1::class, Applicant::class);
        return $this->hasMany(Round1::class);

    }

    public function round2s()
    {
        return $this->hasManyThrough(Round2::class, Applicant::class);
    }

    public function round3s()
    {
        return $this->hasManyThrough(Round3::class, Applicant::class);
    }

    public function applicants()
    {
        return $this->hasMany(Applicant::class);
    }
}
