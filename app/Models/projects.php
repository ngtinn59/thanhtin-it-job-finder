<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class projects extends Model
{
    use HasFactory;
    protected $table = 'projects';
    protected $primaryKey = 'id';
    protected $guarded = [];

    public function profiles()
    {
        return $this->belongsTo(profiles::class,'profiles_id','id');
    }


    public function stacks(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(stacks::class, 'projects_id', 'id');
    }
}

