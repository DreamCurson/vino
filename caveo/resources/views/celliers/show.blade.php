@extends('layouts.main')

@section('title', $cellier->nom)

@section('fleche')
<a href="{{ route('celliers.index') }}" class="text-white text-2xl leading-none" aria-label="Retour">
    <img src="{{ asset('images/fleches/gauche-blanc.svg') }}" alt="Flèche de retour" class="w-10 h-10">
</a>
@endsection

@section('content')
<section class="px-4 py-5 pb-48 max-w-5xl mx-auto font-roboto">

    {{-- Header --}}
    <div class="mb-6">
        <h1 class="text-3xl text-[#7A1E2E]" style="font-family: 'Crimson Text', serif;">
            {{ $cellier->nom }}
        </h1>

        <div class="mt-3 text-sm text-gray-700 space-y-1">
            @if($cellier->emplacement)
            <p><strong>Emplacement :</strong> {{ $cellier->emplacement }}</p>
            @endif

            @if($cellier->description)
            <p><strong>Description :</strong> {{ $cellier->description }}</p>
            @endif
        </div>
    </div>

    <x-alerts />

    {{-- Inventaire --}}
    <div class="space-y-4 pb-20">
        @forelse($cellier->inventaires as $inventaire)
        <div class="flex flex-col sm:flex-row gap-4 border p-4 rounded bg-white">

            {{-- Image --}}
            <div class="w-full sm:w-[90px] flex justify-center">
                <img
                    src="{{ $inventaire->bouteille->image ?? asset('images/bouteille-vide.png') }}"
                    alt="{{ $inventaire->bouteille->nom ?? 'Bouteille' }}"
                    class="h-[130px]">
            </div>

            {{-- Contenu --}}
            <div class="flex-1">
                <div class="flex justify-between items-start gap-3">
                    <h2 class="font-semibold">
                        {{ $inventaire->bouteille->nom ?? 'N/A' }}
                    </h2>

                    @if($inventaire->quantite == 0)
                    <span class="bg-red-100 text-red-600 text-xs px-2 py-1 rounded-full shrink-0">
                        Bue
                    </span>
                    @endif
                </div>

                <p class="text-sm text-gray-600">
                    {{ $inventaire->bouteille->pays ?? '' }}
                    @if(!empty($inventaire->bouteille->pays) && !empty($inventaire->bouteille->format)) | @endif
                    {{ $inventaire->bouteille->format ?? '' }}@if(!empty($inventaire->bouteille->format)) ml @endif
                    @if((!empty($inventaire->bouteille->pays) || !empty($inventaire->bouteille->format)) && !empty($inventaire->bouteille->type)) | @endif
                    {{ $inventaire->bouteille->type ?? '' }}
                </p>

                <p class="mt-2">
                    Quantité :
                    <span class="{{ $inventaire->quantite == 0 ? 'text-red-600 font-bold' : '' }}">
                        {{ $inventaire->quantite }}
                    </span>
                </p>

                @if($inventaire->quantite == 0)
                <p class="text-xs text-red-500 mt-1">
                    Cette bouteille est conservée dans le cellier, mais elle a été bue.
                </p>
                @endif

                {{-- Contrôle quantité avec icônes --}}
                <div class="mt-4 flex items-center justify-between w-full">

                    {{-- Moins --}}
                    <form method="POST"
                        action="{{ route('inventaires.updateQuantite', $inventaire) }}"
                        class="w-1/3">
                        @csrf
                        @method('PATCH')

                        <input type="hidden" name="quantite" value="{{ max(0, $inventaire->quantite - 1) }}">

                        <button type="submit"
                            class="w-full flex items-center justify-center py-5"
                            aria-label="Diminuer la quantité">
                            <img src="{{ asset('images/icons/cercle-moins.svg') }}"
                                alt=""
                                aria-hidden="true"
                                class="w-10 h-10">
                        </button>
                    </form>

                    {{-- Quantité --}}
                    <div class="w-1/3 text-center">
                        <span class="text-2xl font-semibold">
                            {{ $inventaire->quantite }}
                        </span>
                    </div>

                    {{-- Plus --}}
                    <form method="POST"
                        action="{{ route('inventaires.updateQuantite', $inventaire) }}"
                        class="w-1/3">
                        @csrf
                        @method('PATCH')

                        <input type="hidden" name="quantite" value="{{ min(999, $inventaire->quantite + 1) }}">

                        <button type="submit"
                            class="w-full flex items-center justify-center py-5"
                            aria-label="Augmenter la quantité">
                            <img src="{{ asset('images/icons/cercle-plus.svg') }}"
                                alt=""
                                aria-hidden="true"
                                class="w-10 h-10">
                        </button>
                    </form>

                </div>

                <p class="text-xs text-gray-500 mt-1">
                    La quantité peut être à 0 si la bouteille a été bue.
                </p>

                {{-- Actions bouteille --}}
                <div class="mt-4 flex gap-3">
                    @if($inventaire->bouteille)
                    <a href="{{ route('bouteilles.show', $inventaire->bouteille->id) }}?source=cellier"
                        class="w-1/2 text-center bg-[#A83248] text-white py-2 rounded text-sm font-medium">
                        Détail
                    </a>
                    @endif

                    <form method="POST"
                        action="{{ route('inventaires.destroy', $inventaire) }}"
                        class="w-1/2">
                        @csrf
                        @method('DELETE')

                        <button type="submit"
                            onclick="return confirm('Supprimer cette bouteille ?')"
                            class="w-full text-center border border-red-300 text-red-600 py-2 rounded text-sm font-medium hover:bg-red-50 transition">
                            Supprimer
                        </button>
                    </form>
                </div>
            </div>
        </div>
        @empty
        <p>Aucune bouteille.</p>
        @endforelse
    </div>

</section>
@endsection