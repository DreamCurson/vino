<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ListeAchat extends Model
{
    use HasFactory;

    protected $fillable = [
        'nom',
        'id_utilisateur',
        'description',
    ];

    public function bouteilles()
    {
        return $this->belongsToMany(
            Bouteille::class,
            'liste_achat_bouteille',
            'id_liste_achat',
            'id_bouteille'
        )->withPivot('quantite');
    }
}
