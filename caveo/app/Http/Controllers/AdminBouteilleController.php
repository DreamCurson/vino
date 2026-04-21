<?php

namespace App\Http\Controllers;

use App\Models\Bouteille;
use Illuminate\Http\Request;

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
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Bouteille $bouteille
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Bouteille $bouteille)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'type' => 'nullable|string|max:100',
            'pays' => 'nullable|string|max:100',
            'cepage' => 'nullable|string|max:255',
            'millesime' => 'nullable|integer|min:1000|max:9999',
            'format' => 'nullable|integer|min:1|max:9999',
            'prix' => 'nullable|numeric|min:0|max:99999.99',
            'description' => 'nullable|string|max:2000',
            'image' => 'nullable|url|max:2048',
            'pastille_gout' => 'nullable|string|max:100',
        ], [
            'nom.required' => 'Le nom de la bouteille est obligatoire.',
            'nom.max' => 'Le nom ne peut pas dépasser 255 caractères.',
            'type.max' => 'Le type ne peut pas dépasser 100 caractères.',
            'pays.max' => 'Le pays ne peut pas dépasser 100 caractères.',
            'cepage.max' => 'Le cépage ne peut pas dépasser 255 caractères.',
            'millesime.integer' => 'Le millésime doit être un nombre entier.',
            'millesime.min' => 'Le millésime doit contenir 4 chiffres valides.',
            'millesime.max' => 'Le millésime doit contenir 4 chiffres valides.',
            'format.integer' => 'Le format doit être un nombre entier.',
            'format.min' => 'Le format doit être supérieur à 0.',
            'format.max' => 'Le format ne peut pas dépasser 9999 ml.',
            'prix.numeric' => 'Le prix doit être un nombre valide.',
            'prix.min' => 'Le prix ne peut pas être négatif.',
            'prix.max' => 'Le prix est trop élevé.',
            'description.max' => 'La description ne peut pas dépasser 2000 caractères.',
            'image.url' => 'Le lien de l’image doit être une URL valide.',
            'image.max' => 'Le lien de l’image ne peut pas dépasser 2048 caractères.',
            'pastille_gout.max' => 'La pastille de goût ne peut pas dépasser 100 caractères.',
        ]);

        $bouteille->update([
            'nom' => $validated['nom'],
            'type' => $validated['type'] ?? null,
            'pays' => $validated['pays'] ?? null,
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
