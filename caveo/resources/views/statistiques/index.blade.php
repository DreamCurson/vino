@extends('layouts.main')
@section('title', 'Profil')
@section('content')
@section('fleche')
    <a href="{{ route('profil.show') }}" class="text-white text-2xl leading-none" aria-label="Retour">
        <img src="/images/fleches/gauche-blanc.svg" alt="Flèche de retour" class="w-10 h-10">
    </a>
@endsection

    <div class="min-h-screen flex flex-col justify-between py-6 px-4 sm:px-6 lg:px-8 pb-32">
        <div>
            <h1 class="text-3xl text-[#7A1E2E] text-center " style="font-family: 'Crimson Text', serif;">Mes Statistiques</h1>
            <div class="mt-4 flex flex-col">
                <div class="text-center border border-b-2 rounded-lg shadow p-3 bg-white ">
                    <span class="text-xl font-medium text-[#7A1E2E]">Valeur totale :</span>
                    <span class="text-2xl font-semibold">{{ number_format($valeurTotale) }} $</span>
                </div>
                <div class="flex flex-col items-center border border-b-2 rounded-xl shadow p-2 mt-4 bg-white">
                    <h3 class="text-xl font-medium text-[#7A1E2E] p-2 pb-4">Mes bouteilles</h3>
                    <div 
                    class="w-40 h-40 rounded-full flex items-center justify-center "
                    style="background: conic-gradient(
                                #8C1D1D 0% {{ $finRouge }}%,
                                #F0DCBF {{ $finRouge }}% {{ $finBlanc }}%,
                                #F0BAA1 {{ $finBlanc }}% {{ $finRose }}%,
                                #1F2937 {{ $finRose }}% 100%
                                );">
                        <div class="w-32 h-32 bg-white rounded-full flex flex-col items-center justify-center">
                            <span class="text-4xl font-bold">{{ $totalBouteilles }}</span>
                        </div>
                    </div>
                    <div class="w-full mt-5 space-y-2 text-sm p-2">
                        @if($rouge > 0)
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-2">
                                <span class="w-3 h-3 rounded-full bg-[#8C1D1D]"></span>
                                <span>Rouge</span>
                            </div>
                            <span>{{ $rouge }} ({{ round($pourcentageRouge) }}%)</span>
                        </div>
                            <div class="w-full h-px bg-gray-300"></div>
                        @endif
                        @if($blanc > 0)
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-2">
                                <span class="w-3 h-3 rounded-full bg-[#F0DCBF]"></span>
                                <span>Blanc</span>
                            </div>
                            <span>{{ $blanc }} ({{ round($pourcentageBlanc) }}%)</span>
                        </div>
                            <div class="w-full h-px bg-gray-300"></div>
                        @endif
                        @if($rose > 0)
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-2">
                                <span class="w-3 h-3 rounded-full bg-[#F0BAA1]"></span>
                                <span>Rosé</span>
                            </div>
                            <span>{{ $rose }} ({{ round($pourcentageRose) }}%)</span>
                        </div>
                            <div class="w-full h-px bg-gray-300"></div>
                        @endif
                        @if($autres > 0)
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-2">
                                <span class="w-3 h-3 rounded-full bg-[#1F2937]"></span>
                                <span>Autres</span>
                            </div>
                            <span>{{ $autres }} ({{ round($pourcentageAutres) }}%)</span>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
            <div class="flex flex-col text-center border border-b-2 rounded-lg shadow p-2 mt-4 bg-white ">
                <h3 class="text-lg font-medium text-[#7A1E2E] p-2">Ajouts récents</h3>
                <div class="divide-y divide-gray-200">
                @foreach($ajoutsRecents as $inv)
                    <div class="flex items-start space-x-2 p-2">
                        <div class="w-[50px] h-[70px] flex justify-center items-center">
                            <img src="{{ $inv->bouteille->image ?? asset('images/bouteille-vide.png') }}" alt="" class="h-full object-contain">
                        </div>
                        <div class="flex-1 min-w-0 flex flex-col justify-between text-left h-[70px]">
                            <div>
                                <p class="text-lg font-semibold text-gray-800 leading-tight truncate">{{ $inv->bouteille->nom }}</p>
                                <p class="text-sm text-gray-500">
                                {{ $inv->bouteille->type }} |
                                {{ $inv->bouteille->format }}ml |
                                {{ $inv->bouteille->pays }}
                                </p>
                            </div>
                            <p class="text-xs text-gray-400 text-right">
                                {{ \Carbon\Carbon::parse($inv->date_ajout)->diffForHumans() }}
                            </p>
                        </div>
                    </div>
                @endforeach
                </div>
            </div>
        </div>
    </div>



@endsection