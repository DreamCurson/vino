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
        return view('profil.show', [
            'user' => Auth::user()
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Utilisateur $utilisateur)
    {
        return view('profil.edit', [
            'user' => Auth::user()
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

        return redirect()->route('profil.show')->with('status', 'Informations mises à jour !');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Utilisateur $utilisateur)
    {
        //
    }
}
