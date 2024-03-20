<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class job_type extends Model
{
    use HasFactory;
    protected $table = 'job_types';
    protected $primaryKey = 'id';
    protected $guarded = [];


    public function jobs()
    {
        return $this->hasMany(Job::class);
    }
}
