@extends('layouts.main')

@section('title', 'Mes celliers')

@section('deconnexion')
<a href="#" id="openDeconnexionModal" class="text-white text-2xl leading-none" aria-label="Deconnexion">
    <img src="/images/icons/deconnexion-blanc.svg" alt="Deconnexion" class="w-8 h-8">
</a>
@endsection

@section('content')
<script type="module" src="{{ asset('js/message-flash-auto.js') }}"></script>
<div class="mb-24">
    <div class="m-4 flex items-start justify-between gap-4">

        <div>
            <h1 class="text-3xl text-[#7A1E2E]" style="font-family: 'Crimson Text', serif;">
                Mes celliers
            </h1>
            <p class="text-sm text-gray-600 mt-1 font-roboto">
                Consultez et gérez vos celliers.
            </p>
        </div>

        <a href="{{ route('celliers.create') }}"
            class="bg-[#A83248] text-white px-3 py-3 rounded font-semibold whitespace-nowrap">
            <img src="{{ asset('images/symbole/ajouter-blanc.svg') }}" alt="Ajouter une liste d'achat" class="w-6 h-6"
                title="Ajouter une liste d'achat" aria-label="Ajouter une liste d'achat">
        </a>
    </div>

    <div class="m-4">
        <x-alerts />
    </div>

    @if($celliers->isEmpty())
    <div class="mt-[30px] mb-[30px] ml-4 mr-4 p-4 bg-yellow-50 border border-yellow-200 text-yellow-800 rounded text-center">
        Vous n’avez encore aucun cellier.
    </div>
    @else
    @foreach($celliers as $cellier)
    <div class="flex gap-6 m-4 mb-6 font-roboto border p-4 rounded bg-white">

        <div class="w-[90px] flex justify-center items-center shrink-0">
            <img
                src="{{ $loop->even
                    ? asset('images/bouteille-rack-inverse.svg')
                    : asset('images/bouteille-rack.svg') }}"
                alt="Illustration du cellier"
                class="w-auto h-[100px]">
        </div>

        <div class="flex flex-col justify-between flex-1 min-w-0">
            <div>
                <h2 class="font-semibold text-lg break-words">
                    {{ $cellier->nom }}
                </h2>

                <div class="flex items-center text-sm text-gray-600 space-x-2 flex-wrap">
                    @if(!empty($cellier->emplacement))
                    <p>{{ $cellier->emplacement }}</p>
                    <span>|</span>
                    @endif

                    <p>{{ $cellier->inventaires_sum_quantite ?? 0 }} bouteille(s)</p>
                </div>

                @if(!empty($cellier->description))
                <p class="mt-2 font-medium mb-3 text-sm text-gray-700">
                    {{ $cellier->description }}
                </p>
                @endif
            </div>

            <div class="mt-3 flex items-center justify-between gap-3">
                <!-- Voir -->
                <a href="{{ route('celliers.show', $cellier) }}"
                    class="px-2 py-2 border border-gray-300 rounded hover:bg-gray-100 flex items-center gap-2 text-gray-600 w-max">
                    <span class="text-sm">Voir le cellier</span>
                </a>

                <div class="flex items-center gap-3">
                    <!-- Modifier -->
                    <a href="{{ route('celliers.edit', $cellier) }}"
                        class="w-10 h-10 flex items-center justify-center border border-gray-300 rounded hover:bg-gray-100"
                        title="Modifier le cellier"
                        aria-label="Modifier le cellier">
                        <img src="{{ asset('images/icons/crayon.svg') }}" alt="" aria-hidden="true" class="w-6 h-6">
                    </a>

                    <!-- Supprimer -->
                    <form method="POST" action="{{ route('celliers.destroy', $cellier) }}" class="inline-flex">
                        @csrf
                        @method('DELETE')

                        <button type="submit"
                            data-confirm="Supprimer ce cellier ?"
                            class="bouton-supprimer w-10 h-10 flex items-center justify-center border border-gray-300 rounded hover:bg-gray-100"
                            title="Supprimer le cellier"
                            aria-label="Supprimer le cellier">

                            <img src="{{ asset('images/icons/poubelle.svg') }}" alt="" aria-hidden="true" class="w-6 h-6">

                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @endforeach
    @endif
</div>
@endsection