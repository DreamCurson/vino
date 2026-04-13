@extends('layouts.main')
@section('title', 'Liste Achat')

@section('fleche')
    <!-- Flèche de retour qui revient à la page précédente (Cellier ou Catalogue) permet de garder les filtres de catalogue si besoin -->
    <a href="{{ url()->previous() }}">
        <img src="{{ asset('images/fleches/gauche-blanc.svg') }}" alt="Flèche de retour" class="w-10 h-10">
    </a>
@endsection

@section('content')
<script type="module" src="{{ asset('js/message-flash-auto.js') }}"></script>
<div class="m-4 flex items-start justify-between gap-4">
    <div>
        <h1 class="text-3xl text-[#7A1E2E]" style="font-family: 'Crimson Text', serif;">
            Mes listes d'achat
        </h1>
        <p class="text-sm text-gray-600 mt-1 font-roboto">
            Consultez et gérez vos liste d'achat.
        </p>
    </div>

    <a href="{{ route('achat.create') }}"
        class="bg-[#A83248] text-white px-4 py-3 rounded font-semibold whitespace-nowrap">
        Nouvelle liste
    </a>
</div>

<div class="m-4">
    <x-alerts />
</div>

@if($listes->isEmpty())
<div class="mt-[30px] mb-[30px] ml-4 mr-4 p-4 bg-yellow-50 border border-yellow-200 text-yellow-800 rounded text-center">
    Vous n’avez encore aucune liste d'achat
</div>
@else
@foreach($listes as $liste)
<div class="flex gap-6 m-4 mb-6 font-roboto border p-4 rounded bg-white">
    {{-- Contenu --}}
    <div class="flex flex-col justify-between flex-1 min-w-0">
        <div>
            <h2 class="font-semibold text-lg break-words">
                {{ $liste->nom }}
            </h2>

            @if(!empty($liste->description))
            <p class="mt-2 font-medium mb-3 text-sm text-gray-700">
                {{ $liste->description }}
            </p>
            @endif
        </div>

        {{-- Actions --}}
        <div class="mt-3 flex items-center justify-between gap-3">
            <!-- Voir -->
            <a href="#"
                class="px-2 py-2 border border-gray-300 rounded hover:bg-gray-100 flex items-center gap-2 text-gray-600 w-max"
                title="Voir le cellier">
                <span class="text-sm">Voir le contenu de la liste d'achat</span>
            </a>

            <div class="flex items-center gap-3">
                <!-- Modifier -->
                <a href="#"
                    class="w-10 h-10 flex items-center justify-center border border-gray-300 rounded hover:bg-gray-100"
                    title="Modifier la liste d'achat"
                    aria-label="Modifier la liste d'achat">
                    <img src="{{ asset('images/icons/crayon.svg') }}" alt="" aria-hidden="true" class="w-6 h-6">
                </a>

                <!-- Supprimer -->
                <form method="POST" action="{{ route('achat.destroy', $liste->id) }}" class="inline-flex">
                    @csrf
                    @method('DELETE')

                    <button type="submit"
                        onclick="return confirm('Supprimer cette liste d\'achat ?')"
                        class="w-10 h-10 flex items-center justify-center border border-gray-300 rounded hover:bg-gray-100"
                        title="Supprimer la liste d'achat"
                        aria-label="Supprimer la liste d'achat">
                        <img src="{{ asset('images/icons/poubelle.svg') }}" alt="" aria-hidden="true" class="w-6 h-6">
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endforeach
@endif

@endsection