<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OnboardingSurvey extends Model
{
    use HasFactory;
    protected $fillable = [
        'survey_id', 'email', 'phone', 'material_due',
    ];

    // Define relationship with Survey
    public function survey()
    {
        return $this->belongsTo(Survey::class);
    }
}
