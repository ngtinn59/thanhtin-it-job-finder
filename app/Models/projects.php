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

}
