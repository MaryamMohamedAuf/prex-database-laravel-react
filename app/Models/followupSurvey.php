<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FollowupSurvey extends Model
{
    use HasFactory;

    protected $fillable = [
        'date',
        'survey_tag',
        'survey_id',
        'status',
        'cohort_id',
    ];

    public function survey()
    {
        return $this->belongsTo(Survey::class);
    }

    public function cohort()
    {
        return $this->belongsTo(Cohort::class);
    }
}
