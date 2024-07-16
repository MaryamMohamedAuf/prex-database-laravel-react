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
    ];

    public function survey()
    {
        return $this->belongsTo(Survey::class);
    }
}
