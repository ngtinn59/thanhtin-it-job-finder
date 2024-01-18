<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class recruitments extends Model
{
    use HasFactory;
    protected $table = 'recruitments';
    protected $primaryKey = 'id';
    protected $guarded = [];



    public function statistic_applies()
    {
        return $this->hasMany(statistic_applies::class,'recruitments_id','id');
    }

    public function Users()
    {
        return $this->belongsTo(User::class,'users_id','id');
    }
}
