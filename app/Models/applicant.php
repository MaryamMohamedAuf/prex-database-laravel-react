<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;


class applicant extends Model
{
    use HasFactory, HasApiTokens, Notifiable;
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'company_name',
        'cohort_id'
    ];
    public function rounds()
    {
        return $this->hasMany(round1::class);
        return $this->hasMany(round3::class);
        return $this->hasMany(round3::class);
    }
    public function cohort()
    {
        return $this->belongsTo(Cohort::class);
    }

}
