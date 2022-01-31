<?php

namespace App\Models;

use App\Models\Menu;
use App\Models\Plat;
use App\Models\Image;
use App\Models\Commande;
use App\Models\Reclamation;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Restaurant extends Model
{
    use HasFactory;


    protected $fillable = [
        'user_id',
        'nom',
        'description',
        'adresse',
        'ville',
        'logitide',
        'latitude',
        'offre',
        'nomGerant',
        'tel',
        'pageFacebook',
        'PageInstagram',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function images()
    {
        return $this->morphMany(Image::class, 'imageable');
    }
    public function reclamations()
    {
        return $this->morphMany(Reclamation::class, 'reclamationable');
    }
    public function menus()
    {
        return $this->hasMany(Menu::class);
    }
    public function commandes()
    {
        return $this->hasMany(Commande::class);
    }
    public function accompagnements()
    {
        return $this->hasMany(Accompagnement::class);
    }
    public function likes()
    {
        return $this->morphMany(Like::class, 'likeable');
    }
}
