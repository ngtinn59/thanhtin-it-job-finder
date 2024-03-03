<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    use HasFactory;
    protected $table = 'jobs';
    protected $primaryKey = 'id';
    protected $guarded = [];

    public function Company()  : \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->belongsTo(Company::class,'company_id','id');
    }

    public function skill()  : \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Jobskill::class,'job_id','id');
    }

    public function jobtype()  : \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Jobtype::class,'id','id');
    }
}
