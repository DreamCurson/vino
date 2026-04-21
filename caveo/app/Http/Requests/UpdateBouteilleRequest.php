<?php

namespace App\Http\Requests;

use App\Models\Bouteille;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateBouteilleRequest extends FormRequest
{
    /**
     * Détermine si l'utilisateur est autorisé à effectuer cette requête.
     *
     * Seuls les administrateurs peuvent modifier une bouteille.
     */
    public function authorize(): bool
    {
        return optional($this->user()?->role)->nom === 'admin';
    }

    /**
     * Obtient les règles de validation applicables à la requête.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $types = Bouteille::whereNotNull('type')
            ->where('type', '!=', '')
            ->distinct()
            ->pluck('type')
            ->all();

        $pays = Bouteille::whereNotNull('pays')
            ->where('pays', '!=', '')
            ->distinct()
            ->pluck('pays')
            ->all();

        $formats = Bouteille::whereNotNull('format')
            ->distinct()
            ->pluck('format')
            ->all();

        $pastilles = Bouteille::whereNotNull('pastille_gout')
            ->where('pastille_gout', '!=', '')
            ->distinct()
            ->pluck('pastille_gout')
            ->all();

        return [
            'nom' => 'required|string|max:255',
            'type' => ['required', 'string', 'max:100', Rule::in($types)],
            'pays' => ['required', 'string', 'max:100', Rule::in($pays)],
            'cepage' => 'nullable|string|max:500',
            'millesime' => 'nullable|integer|digits:4|min:1900|max:' . ((int) date('Y') + 1),
            'format' => ['nullable', 'integer', Rule::in($formats)],
            'prix' => 'nullable|numeric|min:0|max:99999.99',
            'description' => 'nullable|string|max:2000',
            'image' => 'nullable|url|max:2048',
            'pastille_gout' => ['nullable', 'string', 'max:100', Rule::in($pastilles)],
        ];
    }

    /**
     * Obtient les messages personnalisés pour les erreurs de validation.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'nom.required' => 'Le nom de la bouteille est obligatoire.',
            'nom.string' => 'Le nom doit être une chaîne de caractères.',
            'nom.max' => 'Le nom ne peut pas dépasser :max caractères.',

            'type.required' => 'Le type est obligatoire.',
            'type.string' => 'Le type doit être une chaîne de caractères.',
            'type.max' => 'Le type ne peut pas dépasser :max caractères.',
            'type.in' => 'Le type sélectionné n’est pas valide.',

            'pays.required' => 'Le pays est obligatoire.',
            'pays.string' => 'Le pays doit être une chaîne de caractères.',
            'pays.max' => 'Le pays ne peut pas dépasser :max caractères.',
            'pays.in' => 'Le pays sélectionné n’est pas valide.',

            'cepage.string' => 'Le cépage doit être une chaîne de caractères.',
            'cepage.max' => 'Le cépage ne peut pas dépasser :max caractères.',

            'millesime.integer' => 'Le millésime doit être un nombre entier.',
            'millesime.digits' => 'Le millésime doit contenir 4 chiffres.',
            'millesime.min' => 'Le millésime ne peut pas être inférieur à 1900.',
            'millesime.max' => 'Le millésime est trop élevé.',

            'format.integer' => 'Le format doit être un nombre entier.',
            'format.in' => 'Le format sélectionné n’est pas valide.',

            'prix.numeric' => 'Le prix doit être un nombre valide.',
            'prix.min' => 'Le prix ne peut pas être négatif.',
            'prix.max' => 'Le prix est trop élevé.',

            'description.string' => 'La description doit être une chaîne de caractères.',
            'description.max' => 'La description ne peut pas dépasser :max caractères.',

            'image.url' => 'Le lien de l’image doit être une URL valide.',
            'image.max' => 'Le lien de l’image ne peut pas dépasser :max caractères.',

            'pastille_gout.string' => 'La pastille de goût doit être une chaîne de caractères.',
            'pastille_gout.max' => 'La pastille de goût ne peut pas dépasser :max caractères.',
            'pastille_gout.in' => 'La pastille de goût sélectionnée n’est pas valide.',
        ];
    }

    /**
     * Obtient les attributs personnalisés pour les erreurs de validation.
     *
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [
            'nom' => 'nom',
            'type' => 'type',
            'pays' => 'pays',
            'cepage' => 'cépage',
            'millesime' => 'millésime',
            'format' => 'format',
            'prix' => 'prix',
            'description' => 'description',
            'image' => 'lien de l’image',
            'pastille_gout' => 'pastille de goût',
        ];
    }
}
