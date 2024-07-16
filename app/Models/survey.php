<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Survey extends Model
{
    use HasFactory;

    protected $fillable = [
        'ApplicantName',
        'CohortTag',
    ];

    public function followupSurveys()
    {
        return $this->hasMany(FollowupSurvey::class);
        return $this->hasMany(OnboardingSurvey::class);

    }
}
