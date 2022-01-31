<?php

namespace App\Models;

use App\Models\Plat;
use App\Models\Client;
use App\Models\Restaurant;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Commande extends Model
{
    use HasFactory;

    public function accompagnements()
    {
        return $this->belongsToMany(Accompagnement::class, 'commande_accompagnement', 'commande_id', 'accompagnement_id')
            ->withPivot('quantity');
    }
    public function plat()
    {
        return $this->belongsTo(Plat::class);
    }
    public function client()
    {
        return $this->belongsTo(Client::class);
    }
    public function restaurant()
    {
        return $this->belongsTo(Restaurant::class);
    }
}
