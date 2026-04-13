@extends('layouts.main')

@section('title', 'Créer une liste d\'achat ')

@section('fleche')
<a href="{{ url()->previous() }}" class="text-white text-2xl leading-none" aria-label="Retour">
    <img src="/images/fleches/gauche-blanc.svg" alt="Flèche de retour" class="w-10 h-10">
</a>
@endsection

@section('content')

<div class="m-4">
    <h1 class="text-3xl text-[#7A1E2E]" style="font-family: 'Crimson Text', serif;">
        Créer une liste d'achat
    </h1>
    <p class="text-sm text-gray-600 mt-1 font-roboto">
        Ajouter une nouvelle liste d'achat à votre profil
    </p>
</div>

<div class="m-4 border p-4 mb-24 rounded bg-white font-roboto">
    <form method="POST" action="{{ route('achat.store') }}" class="flex flex-col gap-5" novalidate>
        @csrf

        @include('liste-achat._form')

        <div class="flex gap-3 pt-2">
            <button type="submit" class="w-1/2 bg-[#A83248] text-white py-3 rounded font-medium">
                Enregistrer
            </button>

            <a href="{{ url()->previous() }}"
                class="w-1/2 text-center border py-3 rounded font-medium">
                Annuler
            </a>
        </div>
    </form>
</div>

@endsection