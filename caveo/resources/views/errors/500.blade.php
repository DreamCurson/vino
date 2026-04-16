@extends('layouts.erreurs')

@section('title', 'Erreur serveur')

@section('content')
<div class="max-w-sm px-6">

    <div class="text-6xl font-bold text-[#7A1E2E]">500</div>

    <h1 class="text-xl font-semibold mt-4">Erreur serveur</h1>

    <p class="text-gray-600 mt-2">
        Une erreur est survenue. Réessaie plus tard.
    </p>

    <a href="{{ route('accueil') }}"
       class="mt-6 inline-block px-5 py-3 bg-[#7A1E2E] text-white rounded-lg active:scale-95 transition">
        Retour à l’accueil
    </a>
</div>
@endsection