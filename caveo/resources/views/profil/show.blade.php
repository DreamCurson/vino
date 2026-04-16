@extends('layouts.main')
@section('title', 'Profil')
@section('content')
    <script type="module" src="{{ asset('js/message-flash-auto.js') }}"></script>
    
        <div class="h-[calc(100vh-90px)] flex flex-col justify-between py-6 px-4 sm:px-6 lg:px-8 pb-24">
            <div>
                <h1 class="text-3xl text-[#7A1E2E] text-center " style="font-family: 'Crimson Text', serif;">Mon Profil</h1>
                <x-alerts />
                <h3 class="text-xl font-medium mt-1 ">Mes Informations</h3>
                    <div class="flex justify-between border rounded-lg shadow p-2 bg-white ">
                        <div>
                            <p class="text-lg">{{ $user->prenom }} {{ $user->nom }}</p>
                            <p class="text-xs text-gray-500">{{ $user->email }}</p>
                        </div>
                        <div class="my-2 flex justify-end">
                            <a href="{{ route('profil.edit') }}" class=" p-1 border border-gray-300 rounded flex items-center gap-2 text-gray-600 shadow w-max">
                                <img src="{{ asset('images/icons/crayon.svg') }}" alt="" aria-hidden="true" class="w-6 h-6">
                            </a>
                        </div>
                    </div>
            </div>
                <div class="flex flex-col gap-3 items-center">
                    <a href="{{ route('deconnexion') }}" class="w-3/5 max-w-xs  p-1 flex items-center justify-center border bg-[#7A1E2E] border-[#7A1E2E]  text-white rounded-md shadow">Se déconnecter</a>
                    <form method="POST" action="{{ route('profil.destroy') }}" class="w-3/5 max-w-xs">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                                onclick="return confirm('Es-tu sûr de vouloir supprimer ton compte?')"
                                class="w-full  p-1 flex items-center justify-center border bg-white border-gray-300 rounded-md shadow">
                                Supprimer mon compte
                        </button>
                    </form>
                </div>
        </div>

@endsection