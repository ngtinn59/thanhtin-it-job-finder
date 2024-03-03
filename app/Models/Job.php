<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Job extends Model
{
    use HasFactory;
    protected $table = 'jobs';
    protected $primaryKey = 'id';
    protected $guarded = [];

    public function Company()
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

    public function checkSaved(){
        return DB::table('favorites')->where('user_id', auth()->user()->id)->where('job_id', $this->id)->exists();
    }

    public function favorites(){
        return $this->belongsToMany(Job::class, 'favorites', 'job_id', 'user_id')->withTimestamps();
    }
    public function checkApplication(){
        return DB::table('job_user')->where('user_id', auth()->user()->id)->where('job_id', $this->id)->exists();
    }

}
