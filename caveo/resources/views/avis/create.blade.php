@extends('layouts.main')

@section('title', 'Ajouter un avis')

@section('content')

    <div class="m-4">
        <h1 class="text-2xl text-[#7A1E2E] mb-4 font-semibold">
            Ajouter mon avis
        </h1>

        <form method="POST" action="{{ route('avis.store') }}">
            @csrf

            @include('avis._form')

        </form>
    </div>

@endsection