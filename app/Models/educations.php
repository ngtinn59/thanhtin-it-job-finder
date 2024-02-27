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

    public function profile()
    {
        return $this->belongsTo(profile::class);
    }

}
