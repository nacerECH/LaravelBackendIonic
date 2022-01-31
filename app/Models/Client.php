<?php

namespace App\Models;

use App\Models\Like;
use App\Models\User;
use App\Models\Commande;
use App\Models\Reclamation;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Client extends Model
{
    use HasFactory;

    protected $fillable = [

        'user_id',
        'ville',
        'logitide',
        'latitude',
        'telephone',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function commandes()
    {
        return $this->hasMany(Commande::class);
    }
    public function likes()
    {
        return $this->hasMany(Like::class);
    }
    public function reclamations()
    {
        return $this->morphMany(Reclamation::class, 'reclamationable');
    }
}
