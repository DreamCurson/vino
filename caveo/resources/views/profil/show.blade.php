@extends('layouts.main')
@section('title', 'Profil')
@section('content')
@section('deconnexion')
<a href="#" id="openDeconnexionModal" class="text-white text-2xl leading-none" aria-label="Deconnexion">
    <img src="/images/icons/deconnexion-blanc.svg" alt="Deconnexion" class="w-8 h-8">
</a>
@endsection
<script type="module" src="{{ asset('js/message-flash-auto.js') }}"></script>

<div class="min-h-[calc(100vh-90px)] overflow-hidden flex flex-col py-6 px-4 sm:px-6 lg:px-8 pb-24">
    <div>
        <h1 class="text-3xl text-[#7A1E2E]" style="font-family: 'Crimson Text', serif;">Mon Profil</h1>
        <x-alerts />
        <div>
            <h3 class="text-xl font-medium mt-3">Mes Informations</h3>
            <div class="flex justify-between border border-b-2 rounded-xl shadow p-3 bg-white">
                <div>
                    <p class="text-lg">{{ $utilisateur->prenom }} {{ $utilisateur->nom }}</p>
                    <p class="text-sm text-gray-500">{{ $utilisateur->email }}</p>
                </div>
                <div class="my-2 flex justify-end">
                    <a href="{{ route('profil.edit') }}" class=" p-1 border border-gray-300 rounded flex items-center gap-2 text-gray-600 shadow w-max">
                        <img src="{{ asset('images/icons/crayon.svg') }}" alt="" aria-hidden="true" class="w-6 h-6" title="Modifier mes informations" aria-label="Modifier mes informations">
                    </a>
                </div>
            </div>
        </div>
        <div class="mt-5">
            <h3 class="text-xl font-medium mt-3 ">Mes statistiques</h3>
            <a href="{{ route('statistiques.index') }}"
                class="block border border-b-2 rounded-xl shadow p-2 bg-white">
                <div class="flex items-stretch gap-3">
                    <div class="flex flex-col flex-1 items-center justify-center p-3">
                        <span class="text-xl text-center font-bold text-[#7A1E2E]"> {{ $totalBouteilles }}</span>
                        <span class="text-md text-gray-600">Bouteilles</span>
                    </div>
                    <div class="w-px h-16 bg-gray-300"></div>
                    <div class="flex flex-col flex-1 items-center justify-center p-3">
                        <span class="text-xl text-center font-bold text-[#7A1E2E]"> {{ number_format($valeurTotale) }}$</span>
                        <span class="text-md text-gray-600">Valeur totale</span>
                    </div>
                </div>
                <p class="text-xs text-gray-400 mt-2 text-center">Voir les statistiques détaillées</p>
            </a>
        </div>
    </div>
    <div class="mt-auto pt-6 flex justify-center gap-3">
        <form method="POST" action="{{ route('profil.destroy') }}" class="w-3/5 max-w-xs">
            @csrf
            @method('DELETE')
            <button type="submit"
                data-confirm="Êtes-vous sûr de supprimer votre compte ?"
                class="w-full  py-2 flex items-center justify-center border bg-white border-gray-300 rounded-md shadow text-gray-500"
                title="Êtes-vous sûr de supprimer votre compte"
                aria-label="Êtes-vous sûr de supprimer votre compte">
                Supprimer mon compte
            </button>
        </form>
    </div>
</div>

@endsection