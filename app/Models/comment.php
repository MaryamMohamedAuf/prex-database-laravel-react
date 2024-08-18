<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'applicant_id',
        'cohort_id',
        'round1_id',
        'round2_id',
        'round3_id',
        'feedback',
        'decision',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function applicant()
    {
        return $this->belongsTo(Applicant::class);
    }

    public function cohort()
    {
        return $this->belongsTo(Cohort::class);
    }

    public function round1()
    {
        return $this->belongsTo(Round1::class);
    }

    public function round2()
    {
        return $this->belongsTo(Round2::class);
    }

    public function round3()
    {
        return $this->belongsTo(Round3::class);
    }
}
