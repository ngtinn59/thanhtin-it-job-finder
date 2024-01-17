<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class jobs extends Model
{
    use HasFactory;
    protected $table = 'jobs';
    protected $primaryKey = 'id';
    protected $guarded = [];
    public function experiences()
    {
        return $this->hasOne(experiences::class,'jobs_id','id');
    }
}
