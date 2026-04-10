@extends('layouts.main')

@section('title', 'Mes celliers')

@section('content')

<script type="module" src="{{ asset('js/message-flash.js') }}"></script>

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
        class="bg-[#A83248] text-white px-4 py-3 rounded font-semibold whitespace-nowrap">
        Nouveau
    </a>
</div>

<div class="m-4">
    <x-alerts />
</div>

@if($celliers->isEmpty())
<div class="m-4 border p-4 rounded bg-white font-roboto">
    <p>Vous n’avez encore aucun cellier.</p>
</div>
@else
@foreach($celliers as $cellier)
<div class="flex gap-6 m-4 mb-6 font-roboto border p-4 rounded bg-white">
    {{-- Image cellier --}}
    <div class="w-[90px] flex justify-center">
        <img
            src="{{ asset('images/bouteille-vide.png') }}"
            alt="Illustration du cellier"
            class="w-auto h-[135px]">
    </div>

    {{-- Contenu --}}
    <div class="flex flex-col justify-between flex-1 min-w-0">
        <div>
            <h2 class="font-semibold text-lg break-words">
                {{ $cellier->nom }}
            </h2>

            <div class="flex items-center text-sm text-gray-600 space-x-2 flex-wrap">
                <p>{{ $cellier->emplacement ?? 'Non précisé' }}</p>
                <span>|</span>
                <p>{{ $cellier->inventaires_count ?? 0 }} bouteille(s)</p>
            </div>

            <p class="mt-2 font-medium mb-3 text-sm text-gray-700">
                {{ $cellier->description ?? 'Aucune description' }}
            </p>
        </div>

        <div class="flex flex-col gap-2 sm:flex-row sm:items-center">
            <a href="{{ route('celliers.show', $cellier) }}"
                class="px-4 py-2 bg-[#A83248] text-white rounded w-max">
                Voir le cellier
            </a>

            <a href="{{ route('celliers.edit', $cellier) }}"
                class="px-4 py-2 border rounded w-max">
                Modifier
            </a>

            <form method="POST" action="{{ route('celliers.destroy', $cellier) }}">
                @csrf
                @method('DELETE')

                <button
                    type="submit"
                    onclick="return confirm('Voulez-vous vraiment supprimer ce cellier ? Cette action est irréversible.')"
                    class="px-4 py-2 border border-red-300 text-red-600 rounded w-max">
                    Supprimer
                </button>
            </form>
        </div>
    </div>
</div>
@endforeach
@endif

@endsection