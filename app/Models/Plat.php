<?php

namespace App\Models;

use App\Models\Like;
use App\Models\Menu;
use App\Models\Image;
use App\Models\Commande;
use App\Models\Restaurant;
use App\Models\Accompagnement;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Plat extends Model
{
    use HasFactory;

    public function accompagnements()
    {
        return $this->belongsToMany(Accompagnement::class, 'plat_accompagnement', 'plat_id', 'accompagnement_id');
    }
    public function images()
    {
        return $this->morphMany(Image::class, 'imageable');
    }
    public function commandes()
    {
        return $this->hasMany(Commande::class);
    }
    public function menu()
    {
        return $this->belongsTo(Menu::class);
    }
    public function likes()
    {
        return $this->morphMany(Like::class, 'likeable');
    }
    public function restaurant()
    {
        return $this->belongsTo(Restaurant::class);
    }
}
