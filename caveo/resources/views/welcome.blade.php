@extends('layouts.main')

@section('title', 'Caveo')

@section('content')
<section class="min-h-screen bg-[#F8F5F1] flex items-center justify-center px-6 py-12">
    <div class="w-full max-w-3xl mx-auto text-center font-roboto">

        <div class="mb-8">
            <h1 class="text-5xl sm:text-6xl font-semibold text-[#7A1E2E]" style="font-family: 'Crimson Text', serif;">
                Caveo
            </h1>
        </div>

        <div class="mb-10 space-y-3">
            <p class="text-3xl sm:text-5xl leading-tight text-[#1A1A1A] font-light">
                Bienvenue dans votre
            </p>
            <p class="text-4xl sm:text-6xl leading-tight text-[#7A1E2E] italic" style="font-family: 'Crimson Text', serif;">
                cave à vins numérique.
            </p>
            <p class="text-base sm:text-lg text-gray-600 max-w-2xl mx-auto pt-2">
                Gérez votre cellier, ajoutez vos bouteilles et retrouvez vos vins préférés au même endroit.
            </p>
        </div>

        @guest
        <div class="flex flex-col gap-4 max-w-xl mx-auto">
            <a href="{{ route('inscription.form') }}"
                class="w-full bg-[#7A1E2E] text-white py-4 rounded-full text-lg font-medium hover:bg-[#651826] transition">
                Créer un compte
            </a>

            <a href="{{ route('connexion') }}"
                class="w-full bg-[#E9E4E0] text-[#1A1A1A] py-4 rounded-full text-lg font-medium hover:bg-[#DDD6D0] transition">
                Se connecter
            </a>
        </div>
        @endguest


        @auth
        <div class="flex flex-col gap-4 max-w-xl mx-auto">
            <a href="{{ route('celliers.index') }}"
                class="w-full bg-[#7A1E2E] text-white py-4 rounded-full text-lg font-medium hover:bg-[#651826] transition">
                Accéder à mon cellier
            </a>

            <a href="{{ route('catalogue.index') }}"
                class="w-full bg-[#E9E4E0] text-[#1A1A1A] py-4 rounded-full text-lg font-medium hover:bg-[#DDD6D0] transition">
                Explorer le catalogue
            </a>
        </div>
        @endauth

    </div>
</section>
@endsection