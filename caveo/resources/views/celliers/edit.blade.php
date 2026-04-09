@extends('layouts.app')

@section('title', 'Modifier un cellier')

@section('fleche')
<a href="{{ route('celliers.show', $cellier) }}" class="text-white text-2xl leading-none">
    ←
</a>
@endsection

@section('content')
<section class="px-4 py-6 pb-32 max-w-2xl mx-auto">
    <div class="bg-white rounded-2xl shadow border border-gray-100 p-5">
        <h2 class="text-3xl text-[#7A1E2E] mb-5" style="font-family: 'Crimson Text', serif;">
            Modifier le cellier
        </h2>

        <form action="{{ route('celliers.update', $cellier) }}" method="POST" class="space-y-5">
            @csrf
            @method('PUT')

            @include('celliers._form')

            <div class="flex flex-wrap gap-3 pt-2" style="font-family: 'Roboto', sans-serif;">
                <button type="submit"
                    class="bg-[#7A1E2E] text-white px-5 py-2 rounded-lg shadow hover:opacity-90 transition">
                    Mettre à jour
                </button>

                <a href="{{ route('celliers.show', $cellier) }}"
                    class="px-5 py-2 rounded-lg border border-gray-300 text-gray-700 hover:bg-gray-100 transition">
                    Annuler
                </a>
            </div>
        </form>
    </div>
</section>
@endsection