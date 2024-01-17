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
        return $this->hasMany(company_reviews::class);
    }

    public function experience()
    {
        return $this->hasOne(experiences::class);
    }

    public function profiles()
    {
        return $this->belongsTo(profiles::class);
    }

    public function recruitments()
    {
        return $this->hasOne(statistic_applies::class);
    }

    public function users()
    {
        return $this->belongsTo(User::class);
    }

}
