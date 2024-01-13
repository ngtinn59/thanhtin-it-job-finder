<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Symfony\Component\HttpKernel\Profiler\Profile;

class educations extends Model
{
    use HasFactory;

    protected $table = 'educations';
    protected $primaryKey = 'id';
    protected $guarded = [];

    public function profiles()
    {
        return $this->belongsTo(profiles::class);
    }

    public function university()
    {
        return $this->hasMany(universities::class);
    }
}
