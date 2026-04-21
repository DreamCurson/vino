<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Utilisateur;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;


class UtilisateurController extends Controller
{
    /**
     * Display the specified resource.
     */
    public function show(Utilisateur $utilisateur)
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

        return view('profil.show', [
            'utilisateur' => $utilisateur,
            'valeurTotale' => $valeurTotale,
            'totalBouteilles' => $totalBouteilles,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Utilisateur $utilisateur)
    {
        return view('profil.edit', [
            'utilisateur' => Auth::user()
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Utilisateur $utilisateur)
    {
        $utilisateur = Auth::user();

        $request->validate([
            'prenom' => 'required|string|max:255',
            'nom' => 'required|string|max:255',
            'email' => 'required|email|unique:utilisateurs,email,' . $utilisateur->id,
        ]);

        $utilisateur->update([
            'prenom' => $request->prenom,
            'nom' => $request->nom,
            'email' => $request->email,
        ]);

        return redirect()->route('profil.show')->with('success', 'Informations mises à jour!');
    }

    /**
     * Affiche le formulaire de modification du mot de passe.
     */
    public function editPassword()
    {
        return view('profil.edit-password');

    }

    /**
     * Met à jour le mot de passe de l'utilisateur.
     */
    public function updatePassword(Request $request)
    {

        $utilisateur = Auth::user();

        if (!Hash::check($request->ancien_mot_de_passe, $utilisateur->mot_de_passe)) {
            return back()->withErrors(['ancien_mot_de_passe' => 'Mot de passe incorrect']);
        }

        $request->validate([
            'nouveau_mot_de_passe' => 'required|min:8',
            'nouveau_mot_de_passe_confirmation' => 'required|same:nouveau_mot_de_passe',
        ], [
            'nouveau_mot_de_passe.min' => 'Minimum 8 caractères',
            'nouveau_mot_de_passe_confirmation.same' => 'Les mots de passe ne correspondent pas',
        ]);

        $utilisateur->mot_de_passe = Hash::make($request->nouveau_mot_de_passe);
        $utilisateur->save();


        return redirect()->route('profil.edit')->with('success', 'Mot de passe modifié!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Utilisateur $utilisateur)
    {
        $utilisateur = Auth::user();

        $utilisateur->delete();

        return redirect('/')->with('success', 'Votre compte a été supprimé.');
    }
}
