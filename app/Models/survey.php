<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Survey extends Model
{
    use HasFactory;

    protected $fillable = [
        'ApplicantName',
        'cohort_id',
        'CohortTag',
    ];

    public function followupSurveys()
    {
        return $this->hasMany(FollowupSurvey::class);
        return $this->hasMany(OnboardingSurvey::class);

    }
    public function cohort()
    {
        return $this->belongsTo(Cohort::class);
    }
}
