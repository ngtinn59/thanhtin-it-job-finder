<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class profiles extends Model
{
    use HasFactory;


    public function educations()
    {
        return $this->hasMany(educations::class);
    }

    public function experiences()
    {
        return $this->hasMany(experiences::class);
    }

    public function projects()
    {
        return $this->hasMany(projects::class);
    }

    public function skills()
    {
        return $this->hasMany(skills::class);
    }

    public function company()
    {
        return $this->hasMany(companies::class);
    }


    public function User()
    {
        return $this->belongsTo(User::class);
    }
}
