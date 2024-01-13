<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class skills extends Model
{
    use HasFactory;

    public function experience()
    {
        return $this->hasOne(experiences::class);
    }

    public function profiles()
    {
        return $this->belongsTo(profiles::class);
    }


}
