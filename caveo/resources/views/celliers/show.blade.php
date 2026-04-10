@extends('layouts.main')

@section('title', $cellier->nom)

@section('fleche')
<a href="{{ route('celliers.index') }}" class="text-white text-2xl leading-none" aria-label="Retour">
    ←
</a>
@endsection

@section('content')

<section class="px-4 py-5 pb-24 max-w-5xl mx-auto font-roboto">

    {{-- HEADER --}}
    <div class="mb-6">
        <h1 class="text-3xl text-[#7A1E2E]" style="font-family: 'Crimson Text', serif;">
            {{ $cellier->nom }}
        </h1>

        <div class="mt-3 text-sm text-gray-700 space-y-1">
            <p><span class="font-medium">Emplacement :</span> {{ $cellier->emplacement ?? 'Non précisé' }}</p>
            <p><span class="font-medium">Description :</span> {{ $cellier->description ?? 'Aucune description' }}</p>
        </div>

        <div class="mt-4 flex flex-col gap-2 sm:flex-row">
            <a href="{{ route('celliers.edit', $cellier) }}" class="px-4 py-2 border rounded text-center">
                Modifier
            </a>

            <a href="{{ route('celliers.index') }}" class="px-4 py-2 border rounded text-center">
                Retour
            </a>
        </div>
    </div>

    <x-alerts />

    {{-- AJOUT --}}
    <div class="mb-6 border p-4 rounded bg-white">
        <h2 class="font-semibold text-lg mb-4">Ajouter une bouteille</h2>

        <form action="{{ route('inventaires.store', $cellier) }}" method="POST" class="flex flex-col gap-3">
            @csrf

            <select name="id_bouteille" required class="border rounded px-3 py-2 w-full @error('id_bouteille') border-red-500 @enderror">
                <option value="">Choisir une bouteille</option>
                @foreach($bouteilles as $bouteille)
                <option value="{{ $bouteille->id }}" {{ old('id_bouteille') == $bouteille->id ? 'selected' : '' }}>
                    {{ $bouteille->nom }}
                </option>
                @endforeach
            </select>

            @error('id_bouteille')
            <p class="text-red-500 text-sm">{{ $message }}</p>
            @enderror

            <input type="number"
                name="quantite"
                value="{{ old('quantite', 1) }}"
                min="1"
                class="border rounded px-3 py-2 w-full @error('quantite') border-red-500 @enderror">

            @error('quantite')
            <p class="text-red-500 text-sm">{{ $message }}</p>
            @enderror

            <button class="bg-[#A83248] text-white px-4 py-3 rounded font-medium">
                Ajouter
            </button>
        </form>
    </div>

    {{-- INVENTAIRE --}}
    <div class="space-y-4 pb-20">

        @forelse($cellier->inventaires as $inventaire)
        <div class="flex gap-6 border p-4 rounded bg-white">

            {{-- IMAGE --}}
            <div class="w-[90px] flex justify-center">
                <img
                    src="{{ $inventaire->bouteille->image ?? asset('images/bouteille-vide.png') }}"
                    alt="{{ $inventaire->bouteille->nom ?? 'Bouteille' }}"
                    class="w-auto h-[135px]">
            </div>

            {{-- CONTENU --}}
            <div class="flex flex-col justify-between flex-1 min-w-0">

                <div>
                    <div class="flex justify-between items-start">
                        <h2 class="font-semibold text-lg break-words">
                            {{ $inventaire->bouteille->nom ?? 'Bouteille introuvable' }}
                        </h2>

                        @if($inventaire->quantite == 0)
                        <span class="bg-red-100 text-red-600 text-xs px-2 py-1 rounded-full">
                            Rupture
                        </span>
                        @endif
                    </div>

                    <div class="flex items-center text-sm text-gray-600 space-x-2 flex-wrap">
                        <p>{{ $inventaire->bouteille->pays ?? '' }}</p>
                        <span>|</span>
                        <p>{{ $inventaire->bouteille->format ?? '' }} ml</p>
                        <span>|</span>
                        <p>{{ $inventaire->bouteille->type ?? '' }}</p>
                    </div>

                    @if($inventaire->bouteille->prix)
                    <p class="mt-2 font-medium mb-2">
                        {{ $inventaire->bouteille->prix }} $
                    </p>
                    @endif

                    <p class="text-sm mb-2">
                        Quantité :
                        <span class="{{ $inventaire->quantite == 0 ? 'text-red-600 font-bold' : '' }}">
                            {{ $inventaire->quantite }}
                        </span>
                    </p>

                    @if($inventaire->quantite == 0)
                    <p class="text-xs text-red-500 mb-3">
                        Cette bouteille est conservée dans le cellier, mais n’est plus en stock.
                    </p>
                    @endif
                </div>

                {{-- ACTIONS --}}
                <div class="flex flex-col gap-3">

                    {{-- UPDATE --}}
                    <form method="POST" action="{{ route('inventaires.update', $inventaire) }}" class="flex gap-2">
                        @csrf
                        @method('PUT')

                        <input type="number"
                            name="quantite"
                            value="{{ $inventaire->quantite }}"
                            min="0"
                            class="border rounded px-3 py-2 w-full">

                        <button class="px-4 py-2 bg-[#A83248] text-white rounded">
                            OK
                        </button>
                    </form>

                    <p class="text-xs text-gray-500">
                        Mets 0 pour indiquer qu’il n’y a plus de stock.
                    </p>

                    <div class="flex flex-col gap-2 sm:flex-row">

                        @if($inventaire->bouteille)
                        <a href="{{ route('bouteilles.show', $inventaire->bouteille->id) }}?source=cellier"
                            class="px-4 py-2 bg-[#A83248] text-white rounded w-max">
                            Détail
                        </a>
                        @endif

                        <form method="POST" action="{{ route('inventaires.destroy', $inventaire) }}">
                            @csrf
                            @method('DELETE')

                            <button onclick="return confirm('Supprimer cette bouteille ?')"
                                class="px-4 py-2 border border-red-300 text-red-600 rounded w-max">
                                Supprimer
                            </button>
                        </form>

                    </div>
                </div>

            </div>
        </div>

        @empty
        <div class="border p-4 rounded bg-white">
            <p>Aucune bouteille dans ce cellier</p>
        </div>
        @endforelse

    </div>

</section>

@endsection