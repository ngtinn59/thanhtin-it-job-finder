<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class experiences extends Model
{
    use HasFactory;


    protected $table = 'experiences';
    protected $primaryKey = 'id';
    protected $guarded = [];

    public function profile()
    {
        return $this->belongsTo(profiles::class);
    }

    public function company()
    {
        return $this->hasOne(companies::class);
    }

    public function job()
    {
        return $this->hasOne(jobs::class);
    }

    public function skill()
    {
        return $this->hasOne(skills::class);
    }
}
