<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateBouteilleRequest;
use App\Models\Bouteille;

/**
 * Contrôleur de gestion des bouteilles (administration).
 *
 * Gère la modification des informations d'une bouteille
 * depuis le catalogue par un administrateur.
 */
class AdminBouteilleController extends Controller
{
    /**
     * Affiche le formulaire de modification d'une bouteille.
     *
     * @param \App\Models\Bouteille $bouteille
     * @return \Illuminate\View\View
     */
    public function edit(Bouteille $bouteille)
    {
        $types = Bouteille::whereNotNull('type')
            ->where('type', '!=', '')
            ->distinct()
            ->orderBy('type')
            ->pluck('type');

        $pays = Bouteille::whereNotNull('pays')
            ->where('pays', '!=', '')
            ->distinct()
            ->orderBy('pays')
            ->pluck('pays');

        $formats = Bouteille::whereNotNull('format')
            ->distinct()
            ->orderBy('format')
            ->pluck('format');

        $pastilles = Bouteille::whereNotNull('pastille_gout')
            ->where('pastille_gout', '!=', '')
            ->distinct()
            ->orderBy('pastille_gout')
            ->pluck('pastille_gout');

        return view('admin.bouteilles.edition', compact('bouteille', 'types', 'pays', 'formats', 'pastilles'));
    }

    /**
     * Met à jour les informations d'une bouteille.
     *
     * La validation est gérée par UpdateBouteilleRequest.
     *
     * @param \App\Http\Requests\UpdateBouteilleRequest $request
     * @param \App\Models\Bouteille $bouteille
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UpdateBouteilleRequest $request, Bouteille $bouteille)
    {
        $validated = $request->validated();

        $bouteille->update([
            'nom' => $validated['nom'],
            'type' => $validated['type'],
            'pays' => $validated['pays'],
            'cepage' => $validated['cepage'] ?? null,
            'millesime' => $validated['millesime'] ?? null,
            'format' => $validated['format'] ?? null,
            'prix' => $validated['prix'] ?? null,
            'description' => $validated['description'] ?? null,
            'image' => $validated['image'] ?? null,
            'pastille_gout' => $validated['pastille_gout'] ?? null,
        ]);

        return redirect()
            ->route('catalogue.index')
            ->with('success', 'La bouteille a été modifiée avec succès.');
    }
}
