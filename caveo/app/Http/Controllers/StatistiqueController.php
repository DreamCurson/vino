<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StatistiqueController extends Controller
{
    public function index()
    {
        $utilisateur = Auth::user()->load('celliers.inventaires.bouteille');

        // Regroupe tous les inventaires de tous les cellier
        $inventaires = $utilisateur->celliers->flatMap(function ($cellier) {
            return $cellier->inventaires;
        });

        //Calcul la valeur totale
        $valeurTotale = $inventaires->sum(function ($inv) {
            return $inv->quantite * ($inv->bouteille->prix ?? 0);
        });

        //Calcul le nombre total de bouteilles
        $totalBouteilles = $inventaires->sum('quantite');

        //initialise les compteur pour chaque type de vin
        $rouge = 0;
        $blanc = 0;
        $rose = 0;
        $autres = 0;

        //Parcourt tous le inventaires pour compter les bouteilles par type
        foreach ($inventaires as $inventaire ) {
            $type = strtolower($inventaire->bouteille->type ?? '');
            $quantite = $inventaire->quantite ?? 0;

            if (str_contains($type, 'rouge')) {
                $rouge += $quantite;
            } elseif (str_contains($type, 'blanc')) {
                $blanc += $quantite;
            } elseif (str_contains($type, 'ros')) {
                $rose += $quantite;
            } else {
                $autres += $quantite;
            }
        }

        //Calcule le pourcentage de chaque type de vin
        $pourcentageRouge = $totalBouteilles > 0 ? ($rouge / $totalBouteilles) * 100 : 0;
        $pourcentageBlanc = $totalBouteilles > 0 ? ($blanc / $totalBouteilles) * 100 : 0;
        $pourcentageRose = $totalBouteilles > 0 ? ($rose / $totalBouteilles) * 100 : 0;
        $pourcentageAutres = $totalBouteilles > 0 ? ($autres / $totalBouteilles) * 100 : 0;

        //Prépare les valuer cumulatives pour le cercle de progression
        $finRouge = $pourcentageRouge;
        $finBlanc = $finRouge + $pourcentageBlanc;
        $finRose = $finBlanc + $pourcentageRose;

        //Récupère les 3 ajouts récents selon la date d'ajout
        $ajoutsRecents = $inventaires
            ->sortByDesc('date_ajout')
            ->take(3);

        return view('statistiques.index', [
            'utilisateur' => $utilisateur,
            'valeurTotale' => $valeurTotale,
            'totalBouteilles' => $totalBouteilles,
            'ajoutsRecents' => $ajoutsRecents,
            'rouge' => $rouge,
             'blanc' => $blanc,
            'rose' => $rose,
            'autres' => $autres,
            'pourcentageRouge' => $pourcentageRouge,
            'pourcentageBlanc' => $pourcentageBlanc,
            'pourcentageRose' => $pourcentageRose,
            'pourcentageAutres' => $pourcentageAutres,
            'finRouge' => $finRouge,
            'finBlanc' => $finBlanc,
            'finRose' => $finRose,
        ]);
    }
}
