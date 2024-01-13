<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class statistic_applies extends Model
{
    use HasFactory;

    public function statistic_applies()
    {
        return $this->belongsTo(statistic_applies::class);
    }

    public function comany()
    {
        return $this->hasOne(companies::class);
    }

}
