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
    ];

    public function applicant()
    {
        return $this->belongsTo(Applicant::class);
    }
}
