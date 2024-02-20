<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Formofwork extends Model
{
    use HasFactory;
    protected $table = 'form_of_work';
    protected $primaryKey = 'id';
    protected $guarded = [];

    public function recruitments(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->belongsTo(recruitments::class);
    }
}
