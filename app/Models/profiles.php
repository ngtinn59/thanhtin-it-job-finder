<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class profiles extends Model
{
    use HasFactory;
    protected $table = 'profiles';
    protected $primaryKey = 'id';
    protected $guarded = [];



    public function educations()
    {
        return $this->hasMany(educations::class);
    }

    public function experiences()
    {
        return $this->hasMany(experiences::class, 'profiles_id','id');
    }

    public function projects()
    {
        return $this->hasMany(projects::class,'profiles_id','id');
    }

    public function skills()
    {
        return $this->hasMany(skills::class,'profiles_id','id');
    }


    public function Users()
    {
        return $this->belongsTo(User::class,'users_id','id');
    }
}
