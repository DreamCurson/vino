@extends('layouts.main')
@section('title', 'caveo')
@section('content')

<div>
    <p>Résultats {{ $bouteilles->firstItem() }}-{{ $bouteilles->lastItem() }} sur {{ $bouteilles->total() }}</p>
</div>

@foreach($bouteilles as $bouteille)
    <div class="flex gap-6 items-start mb-5">
        <img src="{{ $bouteille->image }}" alt="" class="w-16 h-auto object-contain">

        <div>
            <h2 class="font-semibold text-lg">
                {{ $bouteille->nom }}
            </h2>

            <!-- Inline details -->
            <div class="flex items-center text-sm text-gray-600 space-x-2">
                <p>{{ $bouteille->pays ?? "" }}</p>
                <span>|</span>
                <p>{{ $bouteille->format ?? "" }} ml</p>
                <span>|</span>
                <p>{{ $bouteille->type ?? "" }}</p>
            </div>

            <!-- Price -->
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
            <img src="{{ asset('images/fleches/gauche-gris.svg') }}" class="w-10" alt="">
        </span>
    @else
        <a href="{{ $bouteilles->previousPageUrl() }}">
            <img src="{{ asset('images/fleches/gauche-rouge.svg') }}" class="w-10 hover:scale-110 transition" alt="">
        </a>
    @endif

    @if ($bouteilles->hasMorePages())
        <a href="{{ $bouteilles->nextPageUrl() }}">
            <img src="{{ asset('images/fleches/droit-rouge.svg') }}" class="w-10 hover:scale-110 transition" alt="">
        </a>
    @else
        <span>
            <img src="{{ asset('images/fleches/droit-gris.svg') }}" class="w-10" alt="">
        </span>
    @endif
</div>

@endsection