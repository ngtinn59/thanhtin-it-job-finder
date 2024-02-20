<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class job_description extends Model
{
    use HasFactory;
    protected $table = 'job_description';
    protected $primaryKey = 'id';
    protected $guarded = [];

    public function recruitments(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->belongsTo(recruitments::class);
    }


}
