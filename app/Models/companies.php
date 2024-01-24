<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class companies extends Model
{
    use HasFactory;

    protected $table = 'companies';
    protected $primaryKey = 'id';
    protected $guarded = [];




    public function reviews()
    {
        return $this->hasMany(company_reviews::class,'companies_id', 'id');
    }

    public function experiences()
    {
        return $this->hasMany(experiences::class, 'companies_id', 'id');
    }

    public function profiles()
    {
        return $this->belongsTo(profiles::class,'profiles_id','id');
    }

    public function recruitments()
    {
        return $this->hasOne(statistic_applies::class,'companies_id', 'id');
    }

    public function users()
    {
        return $this->belongsTo(User::class, 'users_id', 'id');
    }

}
