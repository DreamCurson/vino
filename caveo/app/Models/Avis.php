<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Avis extends Model
{
    use HasFactory;

    // Nom de la table
    protected $table = 'avis';

    // Attributs
    protected $fillable = [
        'id_utilisateur',
        'id_bouteille',
        'note',
        'commentaire',
    ];

    // Fonction permettant de retourner l'utilisateur qui laisse l'avis
    public function utilisateur()
    {
        return $this->belongsTo(Utilisateur::class, 'id_utilisateur');
    }

    // Fonction permettant de retourner la bouteille liée à l'avis
    public function bouteille()
    {
        return $this->belongsTo(Bouteille::class, 'id_bouteille');
    }
}