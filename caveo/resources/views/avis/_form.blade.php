<div class="flex flex-col gap-4 font-roboto">

    <!-- Note -->
    <div>
        <label for="note" class="block mb-2 font-semibold text-[#1A1A1A]">
            Note
        </label>

        <select id="note" name="note" required
            class="w-full border rounded px-3 py-3 @error('note') border-red-500 @enderror">

            <option value="">Choisir une note</option>

            @for ($i = 0.5; $i <= 5; $i += 0.5)
                <option value="{{ $i }}" {{ old('note', $avis->note ?? '') == $i ? 'selected' : '' }}>
                    {{ $i }} / 5
                </option>
            @endfor
        </select>

        @error('note')
            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
        @enderror
    </div>

    <!-- Commentaire -->
    <div>
        <label for="commentaire" class="block mb-2 font-semibold text-[#1A1A1A]">
            Commentaire
        </label>

        <textarea id="commentaire" name="commentaire" rows="4" placeholder="Ajoutez un commentaire (optionnel)"
            class="w-full border rounded px-3 py-3 @error('commentaire') border-red-500 @enderror">{{ old('commentaire', $avis->commentaire ?? '') }}</textarea>

        @error('commentaire')
            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
        @enderror
    </div>

    <!-- Champ caché bouteille -->
    @if (!isset($avis))
        <input type="hidden" name="id_bouteille" value="{{ $bouteille->id }}">
    @endif

    <!-- Bouton -->
    <div class="mt-2">
        <button type="submit" class="w-full bg-[#A83248] text-white px-4 py-3 rounded font-semibold">
            {{ isset($avis) ? 'Modifier mon avis' : 'Ajouter mon avis' }}
        </button>
    </div>

</div>