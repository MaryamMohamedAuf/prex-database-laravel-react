<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class applicant extends Model
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'company_name',
        'cohort_id',
    ];

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function round1()
    {
        return $this->hasMany(Round1::class, 'applicant_id');
    }

    public function round2()
    {
        return $this->hasMany(Round2::class, 'applicant_id');
    }

    public function round3()
    {
        return $this->hasMany(Round3::class, 'applicant_id');
    }

    public function cohort()
    {
        return $this->belongsTo(Cohort::class);
    }
}
