@extends('layouts.main')
@section('title', 'caveo')
@section('content')

<div class="m-4">
    <!-- 
        Le formulaire envoie une requête GET vers l'URL actuelle.
        url()->current() permet de rester sur la même page (index du catalogue)
        et d'ajouter simplement le paramètre ?recherche=... dans l'URL.

        Exemple : /catalogue?recherche=vin

        Avantages :
        - Permet de partager l’URL avec la recherche
        - Évite de créer une route spécifique pour la recherche
    -->
    <form method="GET" action="{{ url()->current() }}" class="flex gap-2">
        <input 
            type="text" 
            name="recherche" 
            value="{{ request('recherche') }}" 
            placeholder="Rechercher une bouteille..." 
            class="border rounded px-3 py-2 w-full"
        >

        <button type="submit" class="bg-[#A83248] text-white px-4 py-2 rounded">
            <img src="{{ asset('images/recherche/recherche-blanc.svg') }}" alt="" class="w-10 h-10">
        </button>
    </form>
</div>

<div class="m-4">
    <p>Résultats {{ $bouteilles->firstItem() }}-{{ $bouteilles->lastItem() }} sur {{ $bouteilles->total() }}</p>
</div>

@foreach($bouteilles as $bouteille)
    <div class="flex gap-6 items-start m-4">
        <img src="{{ $bouteille->image }}" alt="" class="w-16 h-auto object-contain">

        <div>
            <!-- Affichage du nom en plus grand -->
            <h2 class="font-semibold text-lg">
                {{ $bouteille->nom }}
            </h2>

            <!-- Affichage en ligne du pays, du format et du type -->
            <div class="flex items-center text-sm text-gray-600 space-x-2">
                <p>{{ $bouteille->pays ?? "" }}</p>
                <span>|</span>
                <p>{{ $bouteille->format ?? "" }} ml</p>
                <span>|</span>
                <p>{{ $bouteille->type ?? "" }}</p>
            </div>

            <!-- Affichage du prix -->
            <p class="mt-2 font-medium">
                {{ $bouteille->prix ?? "Non spécifié" }} $
            </p>

            <a href="#" class="button">Détail</a>
        </div>
    </div>
@endforeach

<div class="flex justify-between items-center mx-auto my-5 mb-24">
    @if ($bouteilles->onFirstPage())
        <span>
            <img src="{{ asset('images/fleches/gauche-gris.svg') }}" class="w-14" alt="">
        </span>
    @else
        <a href="{{ $bouteilles->previousPageUrl() }}">
            <img src="{{ asset('images/fleches/gauche-rouge.svg') }}" class="w-14" alt="">
        </a>
    @endif

    <p>Résultats {{ $bouteilles->firstItem() }}-{{ $bouteilles->lastItem() }} sur {{ $bouteilles->total() }}</p>

    @if ($bouteilles->hasMorePages())
        <a href="{{ $bouteilles->nextPageUrl() }}">
            <img src="{{ asset('images/fleches/droit-rouge.svg') }}" class="w-14" alt="">
        </a>
    @else
        <span>
            <img src="{{ asset('images/fleches/droit-gris.svg') }}" class="w-14" alt="">
        </span>
    @endif
</div>

@endsection