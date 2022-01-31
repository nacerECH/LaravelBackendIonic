<?php

namespace App\Models;

use App\Models\Plat;
use App\Models\Image;
use App\Models\Restaurant;
use App\Models\Accompagnement;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Menu extends Model
{
    use HasFactory;

    public function plats()
    {
        return $this->hasMany(Plat::class);
    }

    public function accompagnements()
    {
        return $this->belongsToMany(Accompagnement::class, 'plats_accompagnements', 'plat_id', 'accompagnement_id');
    }
    public function images()
    {
        return $this->morphMany(Image::class, 'imageable');
    }
    public function restaurant()
    {
        return $this->belongsTo(Restaurant::class);
    }
}
