@extends('layouts.main')

@section('title', 'Caveo')


@section('deconnexion')
@auth
<a href="#" id="openDeconnexionModal" class="text-white text-2xl leading-none" aria-label="Deconnexion">
    <img src="/images/icons/deconnexion-blanc.svg" alt="Deconnexion" class="w-8 h-8">
</a>
@endauth
@endsection

@section('content')
<section class="min-h-[calc(100vh-140px)] bg-[#F8F5F1] flex items-center justify-center px-6 py-10">
    <div class="w-full max-w-xl mx-auto text-center font-roboto">

        <!-- <div class="mb-8">
            <h1 class="text-5xl sm:text-6xl tracking-tight text-[#7A1E2E]"
                style="font-family: 'Crimson Text', serif;">
                Caveo
            </h1>
        </div> -->

        <div class="mb-10">
            <p class="text-4xl sm:text-6xl leading-[0.95] tracking-tight text-[#1A1A1A] font-semibold">
                Votre cave,
            </p>
            <p class="mt-2 text-4xl sm:text-6xl leading-[0.95] tracking-tight text-[#7A1E2E] italic"
                style="font-family: 'Crimson Text', serif;">
                réinventée.
            </p>

            <p class="mt-5 text-base sm:text-lg leading-relaxed text-gray-600 max-w-md mx-auto">
                Gérez vos bouteilles, vos celliers et vos listes d’achat dans une expérience simple, élégante et pensée pour le quotidien.
            </p>
        </div>

        <div class="max-w-sm mx-auto space-y-3">
            @guest
            <a href="{{ route('inscription.form') }}"
                class="block w-full rounded-full bg-[#7A1E2E] px-6 py-4 text-lg font-medium text-white hover:bg-[#651826] transition">
                Créer un compte
            </a>

            <a href="{{ route('connexion') }}"
                class="block w-full rounded-full bg-[#E9E4E0] px-6 py-4 text-lg font-medium text-[#1A1A1A] hover:bg-[#DDD6D0] transition">
                Se connecter
            </a>
            @endguest

            @auth
            <a href="{{ route('celliers.index') }}"
                class="block w-full rounded-full bg-[#7A1E2E] px-6 py-4 text-lg font-medium text-white hover:bg-[#651826] transition">
                Accéder à mes celliers
            </a>
            @endauth

            @auth
            <a href="{{ route('catalogue.index') }}"
                class="block w-full rounded-full bg-[#E9E4E0] px-6 py-4 text-lg font-medium text-[#1A1A1A] hover:bg-[#DDD6D0] transition">
                Explorer le catalogue
            </a>
            @endauth
        </div>

    </div>
</section>
@endsection