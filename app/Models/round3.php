<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class round3 extends Model
{
    use HasFactory;

    protected $fillable = [
        'applicant_id',
        'final_decision',
        'recorded_meeting_link',
        'cohort_id',

    ];

    public function applicant()
    {
        return $this->belongsTo(Applicant::class);
    }

    public function cohort()
    {
        return $this->belongsTo(Cohort::class);
    }
}
