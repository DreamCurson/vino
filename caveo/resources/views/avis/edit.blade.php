@extends('layouts.main')

@section('title', 'Modifier mon avis')

@section('content')

    <div class="m-4">
        <h1 class="text-2xl text-[#7A1E2E] mb-4 font-semibold">
            Modifier mon avis
        </h1>

        <form method="POST" action="{{ route('avis.update', $avis->id) }}">
            @csrf
            @method('PATCH')

            @include('avis._form')

        </form>
    </div>

@endsection