@extends('layouts.main')

@section('title', 'Modifier une bouteille')

@section('fleche')
<a href="{{ route('catalogue.index') }}" class="text-white text-2xl leading-none" aria-label="Retour">
    <img src="{{ asset('images/fleches/gauche-blanc.svg') }}" alt="Flèche de retour" class="w-10 h-10">
</a>
@endsection

@section('content')

<script type="module" src="{{ asset('js/apercu-image.js') }}"></script>

<div class="m-4">
    <h1 class="text-3xl text-[#7A1E2E]" style="font-family: 'Crimson Text', serif;">
        Modifier une bouteille
    </h1>
    <p class="text-sm text-gray-600 mt-1 font-roboto">
        Mettez à jour les informations de la bouteille du catalogue.
    </p>
</div>

<div class="m-4">
    <x-alerts />
</div>

<form method="POST"
    action="{{ route('admin.bouteilles.update', $bouteille) }}"
    class="font-roboto" novalidate>
    @csrf
    @method('PUT')

    <div class="mx-4 mb-28 bg-white rounded-2xl shadow-sm">

        <div class="p-4 flex flex-col gap-6">

            <!-- NOM -->
            <div>
                <label for="nom" class="font-semibold block mb-2 text-sm">
                    Nom de la bouteille <span class="text-red-500">*</span>
                </label>
                <input type="text"
                    id="nom"
                    name="nom"
                    value="{{ old('nom', $bouteille->nom) }}"
                    placeholder="Ex. Château Exemple"
                    class="w-full border rounded px-3 py-2 text-sm @error('nom') border-red-500 @enderror"
                    required>
                @error('nom')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- TYPE -->
            <div>
                <label for="type" class="font-semibold block mb-2 text-sm">
                    Type
                </label>
                <select name="type"
                    id="type"
                    class="w-full border rounded px-3 py-2 text-sm @error('type') border-red-500 @enderror">
                    <option value="">Sélectionner un type</option>
                    @foreach($types as $t)
                    <option value="{{ $t }}" {{ old('type', $bouteille->type) === $t ? 'selected' : '' }}>
                        {{ $t }}
                    </option>
                    @endforeach
                </select>
                @error('type')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- PAYS -->
            <div>
                <label for="pays" class="font-semibold block mb-2 text-sm">
                    Pays
                </label>
                <select name="pays"
                    id="pays"
                    class="w-full border rounded px-3 py-2 text-sm @error('pays') border-red-500 @enderror">
                    <option value="">Sélectionner un pays</option>
                    @foreach($pays as $p)
                    <option value="{{ $p }}" {{ old('pays', $bouteille->pays) === $p ? 'selected' : '' }}>
                        {{ $p }}
                    </option>
                    @endforeach
                </select>
                @error('pays')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- FORMAT + MILLÉSIME -->
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label for="format" class="font-semibold block mb-2 text-sm">
                        Format (ml)
                    </label>
                    <select name="format"
                        id="format"
                        class="w-full border rounded px-3 py-2 text-sm @error('format') border-red-500 @enderror">
                        <option value="">Sélectionner un format</option>
                        @foreach($formats as $f)
                        <option value="{{ $f }}" {{ (string) old('format', $bouteille->format) === (string) $f ? 'selected' : '' }}>
                            {{ $f }} ml
                        </option>
                        @endforeach
                    </select>
                    @error('format')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="millesime" class="font-semibold block mb-2 text-sm">
                        Millésime
                    </label>
                    <input type="number"
                        id="millesime"
                        name="millesime"
                        value="{{ old('millesime', $bouteille->millesime) }}"
                        class="w-full border rounded px-3 py-2 text-sm @error('millesime') border-red-500 @enderror">
                    @error('millesime')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- CÉPAGE + PRIX -->
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label for="cepage" class="font-semibold block mb-2 text-sm">
                        Cépage
                    </label>
                    <input type="text"
                        id="cepage"
                        name="cepage"
                        value="{{ old('cepage', $bouteille->cepage) }}"
                        class="w-full border rounded px-3 py-2 text-sm @error('cepage') border-red-500 @enderror">
                    @error('cepage')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="prix" class="font-semibold block mb-2 text-sm">
                        Prix
                    </label>
                    <input type="number"
                        step="0.01"
                        id="prix"
                        name="prix"
                        value="{{ old('prix', $bouteille->prix) }}"
                        class="w-full border rounded px-3 py-2 text-sm @error('prix') border-red-500 @enderror">
                    @error('prix')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- IMAGE -->
            <div>
                <label for="image" class="font-semibold block mb-2 text-sm">
                    Lien de l'image (SAQ)
                </label>
                <div class="flex items-start gap-3 mb-2">
                    <img id="imagePreview"
                        src="{{ old('image', $bouteille->image) }}"
                        alt="Aperçu de l'image"
                        class="h-24 rounded border {{ old('image', $bouteille->image) ? '' : 'hidden' }}">
                </div>
                <input type="url"
                    id="image"
                    name="image"
                    value="{{ old('image', $bouteille->image) }}"
                    placeholder="https://www.saq.com/..."
                    class="w-full border rounded px-3 py-2 text-sm @error('image') border-red-500 @enderror">
                @error('image')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- PASTILLE DE GOÛT -->
            <div>
                <label for="pastille_gout" class="font-semibold block mb-2 text-sm">
                    Pastille de goût
                </label>
                <select name="pastille_gout"
                    id="pastille_gout"
                    class="w-full border rounded px-3 py-2 text-sm @error('pastille_gout') border-red-500 @enderror">
                    <option value="">Sélectionner une pastille</option>
                    @foreach($pastilles as $pastille)
                    <option value="{{ $pastille }}" {{ old('pastille_gout', $bouteille->pastille_gout) === $pastille ? 'selected' : '' }}>
                        {{ $pastille }}
                    </option>
                    @endforeach
                </select>
                @error('pastille_gout')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- DESCRIPTION -->
            <div>
                <label for="description" class="font-semibold block mb-2 text-sm">
                    Description
                </label>
                <textarea
                    id="description"
                    name="description"
                    rows="3"
                    class="w-full border rounded px-3 py-2 text-sm @error('description') border-red-500 @enderror">{{ old('description', $bouteille->description) }}</textarea>
                @error('description')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

        </div>

        <!-- Actions sticky -->
        <div class="sticky bottom-0 bg-white z-40 border-t rounded-b-2xl">
            <div class="flex flex-row gap-4 p-4">
                <a href="{{ route('catalogue.index') }}"
                    class="w-1/2 text-center border py-3 rounded font-medium text-sm">
                    Annuler
                </a>
                <button type="submit"
                    class="w-1/2 bg-[#A83248] text-white py-3 rounded font-medium text-sm">
                    Sauvegarder
                </button>
            </div>
        </div>

    </div>
</form>

@endsection
