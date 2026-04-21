<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\ListeAchat;
use App\Models\Bouteille;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * Contrôleur des listes d'achat.
 *
 * Gère :
 * - l'affichage des listes d'achat de l'utilisateur
 * - la création, modification et suppression de listes
 * - la gestion des bouteilles dans une liste (ajout, suppression, quantité)
 */
class ListeAchatController extends Controller
{
    /**
     * Affiche toutes les listes d'achat de l'utilisateur connecté
     * avec les bouteilles associées.
     */
    public function index(){
        $listes = collect();

        if (Auth::check()) {
            $listes = ListeAchat::with('bouteilles') 
                ->where('id_utilisateur', Auth::id())
                ->orderBy('nom')
                ->get();
        }

        return view('liste-achat.index', ['listes' => $listes]);
    }

    /**
     * Affiche le formulaire de création d'une liste d'achat.
     */
    public function create(){
        return view('liste-achat.create');
    }

    /**
     * Enregistre une nouvelle liste d'achat.
     *
     * Étapes :
     * - valide les données du formulaire
     * - associe la liste à l'utilisateur connecté
     * - enregistre la liste en base de données
     * 
     */
    public function store(Request $request)
    {
        $utilisateur = Auth::user();

        $validated = $request->validate([
            'nom' => 'required|string|max:75|',
            'description' => 'nullable|string|max:2000',
        ]);

        ListeAchat::create([
            'nom' => $validated['nom'],
            'id_utilisateur' => $utilisateur->id,
            'description' => $validated['description'] ?? null,
        ]);

        return redirect()
            ->route('achat.index');
    }

    /**
     * Affiche le formulaire de modification d'une liste d'achat.
     * Vérifie que l'utilisateur est bien propriétaire de la liste.
     */
    public function edit(ListeAchat $liste)
    {
        $this->verifierProprietaire($liste);

        return view('liste-achat.edit', compact('liste'));
    }

    /**
     * Met à jour une liste d'achat existante.
     *
     * Étapes :
     * - vérifie le propriétaire
     * - valide les données
     * - met à jour les informations de la liste
     *
     */
    public function update(Request $request, ListeAchat $liste)
    {
        $this->verifierProprietaire($liste);

        $validated = $request->validate([
            'nom' => 'required|string|max:75',
            'description' => 'nullable|string|max:2000',
        ]);

        $liste->update([
            'nom' => $validated['nom'],
            'description' => $validated['description'] ?? null,
        ]);

        return redirect()
            ->route('achat.index')
            ->with('status', 'La liste d\'achat a été modifié avec succès.');
    }

    /**
     * Supprime une liste d'achat.
     * Vérifie que l'utilisateur est propriétaire avant suppression.
     */
    public function destroy(ListeAchat $liste)
    {
        $this->verifierProprietaire($liste);

        $liste->delete();

        return redirect()
            ->route('achat.index')
            ->with('status', 'La liste d\'achat a été supprimé avec succès.');
    }

    /**
     * Vérifie que la liste appartient à l'utilisateur connecté.
     */
    private function verifierProprietaire(ListeAchat $liste): void
    {
        $utilisateur = Auth::user();

        if ($liste->id_utilisateur !== $utilisateur->id) {
            abort(403);
        }
    }

    /**
     * Ajoute une bouteille à une liste d'achat.
     *
     * Étapes :
     * - valide les données
     * - vérifie si la bouteille existe déjà dans la liste
     *   - si oui : met à jour la quantité
     *   - sinon : ajoute la bouteille avec la quantité
     *
     */
    public function addBouteille(Request $request, ListeAchat $liste)
    {
        $validated = $request->validate([
            'id_bouteille' => 'required|integer|exists:bouteilles,id',
            'quantite' => 'required|integer|min:1|max:999',
        ], [
            'id_bouteille.required' => 'La bouteille est obligatoire.',
            'id_bouteille.exists' => 'La bouteille sélectionnée est invalide.',
            'quantite.required' => 'La quantité est obligatoire.',
            'quantite.integer' => 'La quantité doit être un nombre entier.',
            'quantite.min' => 'La quantité doit être d’au moins 1.',
            'quantite.max' => 'La quantité ne peut pas dépasser 999.',
        ]);

        $bouteilleExistante = $liste->bouteilles()
            ->where('id_bouteille', $validated['id_bouteille'])
            ->first();

        if ($bouteilleExistante) {
            $nouvelleQuantite = $bouteilleExistante->pivot->quantite + $validated['quantite'];

            $liste->bouteilles()->updateExistingPivot(
                $validated['id_bouteille'],
                ['quantite' => $nouvelleQuantite]
            );

            return back()->with('status', 'La quantité a été mise à jour.');
        }

        $liste->bouteilles()->attach(
            $validated['id_bouteille'],
            ['quantite' => $validated['quantite']]
        );

        return back();
    }

    /**
     * Retire une bouteille d'une liste d'achat.
     * Vérifie que l'utilisateur est propriétaire de la liste.
     */
    public function removeBouteille(ListeAchat $liste, Bouteille $bouteille)
    {
        if ($liste->id_utilisateur !== auth()->id()) {
            abort(403);
        }

        $liste->bouteilles()->detach($bouteille->id);

        return back()->with('success', 'Bouteille retirée de la liste.');
    }

    /**
     * Met à jour la quantité d'une bouteille dans une liste d'achat.
     *
     * Actions possibles :
     * - increment : augmente la quantité de 1
     * - decrement : diminue la quantité sans descendre sous 1
     *
     */
    public function updateQuantite(Request $request, $listeId, $bouteilleId)
    {
        $liste = ListeAchat::findOrFail($listeId);

        $bouteille = $liste->bouteilles()
            ->where('liste_achat_bouteille.id_bouteille', $bouteilleId)
            ->firstOrFail();

        $pivot = $bouteille->pivot;

        if ($request->action === 'increment') {
            $pivot->quantite++;
        }

        if ($request->action === 'decrement') {
            $pivot->quantite = max(1, $pivot->quantite - 1);
        }

        $pivot->save();

        return back();
    }
}