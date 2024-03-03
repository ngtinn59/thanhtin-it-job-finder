<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;

    protected $table = 'companies';

    protected $primaryKey = 'id';

    protected $guarded = [];

    public function locations()  : \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Location::class,'company_id','id');
    }
    public function Location_Comapny()  : \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->belongsTo(Location_Comapny::class,'location_id','id');
    }

    public function Job()  : \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Job::class,'company_id','id');
    }
}
