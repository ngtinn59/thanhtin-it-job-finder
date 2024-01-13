<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class recruitments extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'slug_title',
        'company_id',
        'position',
        'form_of_work',
        'experience_level',
        'skills_required',
        'experience_details',
        'quantity',
        'min_salary',
        'max_salary',
        'expiration_date',
        'address_work',
        'job_description',
        'job_requirements',
        'benefits',
        'recruitment_status',
    ];
    public function statistic_applies()
    {
        return $this->hasMany(statistic_applies::class);
    }

    public function users()
    {
        return $this->belongsTo(User::class);
    }
}
