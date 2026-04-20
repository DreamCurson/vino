<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Bouteille;
use App\Models\Avis;

class AvisController extends Controller
{

    // Fonction pour afficher le formulaire de création d'un avis
    public function create(Bouteille $bouteille) {
        return view('avis.create', compact('bouteille'));
    }


    // Fonction permettant d'ajouter un avis
    public function store(Request $request) {

        $request->validate(
            [
                'id_bouteille' => 'required|exists:bouteilles,id',
                'note' => 'required|numeric|min:0.5|max:5',
                'commentaire' => 'nullable|string',
            ]
        );

        $utilisateur = Auth::user();

        $avisExistant = Avis::where('id_utilisateur', $utilisateur->id)
            ->where('id_bouteille', $request->id_bouteille)
            ->first();

        if ($avisExistant) {
            return redirect()->back()->with('error', 'Vous avez déjà laissé un avis, veuillez le modifier.');
        }

        Avis::create(
            [
                'id_utilisateur' => $utilisateur->id,
                'id_bouteille' => $request->id_bouteille,
                'note' => $request->note,
                'commentaire' => $request->commentaire,
            ]
        );

        return redirect()->route('bouteilles.show', $request->id_bouteille)
            ->with('status', 'Avis ajouté avec succès.');
        }

    // Fonction permettant d'afficher le formulaire de modification d'un avis
    public function edit(Avis $avis) {
        // Validation que l'utilisateur peut modifier
        if ($avis->id_utilisateur !== Auth::id()) {
            abort(403);
        }

        return view('avis.edit', [
            'avis' => $avis,
            'bouteille' => $avis->bouteille
        ]);
    }

    // Fonction permettant de modifier un avis existant
    public function update(Request $request, Avis $avis) {
       
        $request->validate(
            [
                'note' => 'required|numeric|min:0.5|max:5',
                'commentaire' => 'nullable|string',
            ]
        );

        // Validation que seul l'utilisateur peut modifier
        if ($avis->id_utilisateur !== Auth::id()) {
            abort(403);
        }

        $avis->update([
            'note' => $request->note,
            'commentaire' => $request->commentaire,
        ]);

        return redirect()->route('bouteilles.show', $avis->id_bouteille)
                ->with('status', 'Avis modifié avec succès.');
        }
}
