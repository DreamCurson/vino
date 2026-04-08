<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Utilisateur;
use App\Models\Role;
use App\Http\Requests\InscriptionRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;

class RegisterController extends Controller
{
    /**
     * Enregistrer un nouvel utilisateur dans la base de données.
     */
    public function store(InscriptionRequest $request)
    {
        $data = $request->validated();

        $utilisateur = DB::transaction(function () use ($data) {
            $roleId = Role::where('nom', 'user')->value('id') ?? 2;

            return Utilisateur::create([
                'prenom' => $data['prenom'] ?? '',
                'nom' => $data['nom'] ?? '',
                'email' => $data['courriel'],
                'mot_de_passe' => Hash::make($data['mot_de_passe']),
                'id_role' => $roleId,
            ]);
        });

        // connecte automatiquement l'utilisateur créé,
        // puis redirige vers l'accueil.
        event(new Registered($utilisateur));
        Auth::login($utilisateur);

        return redirect()->intended('/accueil');
    }
}
