@extends('layouts.erreurs')

@section('title', 'Session expirée')

@section('content')
<div class="max-w-sm px-6">

    <div class="text-6xl font-bold text-[#7A1E2E]">419</div>

    <h1 class="text-xl font-semibold mt-4">Session expirée</h1>

    <p class="text-gray-600 mt-2">
        Votre session a expiré. Veuillez réessayer.
    </p>

    <a href="{{ url()->previous() }}"
       class="mt-6 inline-block px-5 py-3 bg-[#7A1E2E] text-white rounded-lg active:scale-95 transition">
        Réessayer
    </a>

    <a href="{{ route('accueil') }}"
       class="mt-3 block text-sm text-gray-500 underline">
        Retour à l’accueil
    </a>

</div>
@endsection