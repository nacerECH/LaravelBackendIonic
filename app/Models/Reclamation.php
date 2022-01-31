<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reclamation extends Model
{
    use HasFactory;
    protected $fillable = [
        'sujet',
        'description',
        'reclamationable_type',
        'reclamationable_id',
    ];

    public function reclamationable()
    {
        return $this->morphTo();
    }
}
