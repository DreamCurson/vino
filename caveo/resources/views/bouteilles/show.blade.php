@extends('layouts.main')
@section('title', 'Fiche détaillée')
@section('fleche')
    @php
        $source = request('source');
        $cellierId = request('cellier');
        $return = request('return');
    @endphp

    @if ($source === 'cellier' && $cellierId)
        <a href="{{ route('celliers.show', $cellierId) }}">
    @elseif ($source === 'catalogue' && $return)
        <a href="{{ url()->previous() }}">
    @else
        <!-- fallback: Retourne de 3 pages si ont est aller dans les reviews -->
        <a href="#" id="js-back-3">
    @endif
        <img src="{{ asset('images/fleches/gauche-blanc.svg') }}" class="w-10 h-10">
    </a>
@endsection
@section('content')
    <script type="module" src="{{ asset('js/message-flash-auto.js') }}"></script>
    <script type="module" src="{{ asset('js/confirmation-suppression.js') }}"></script>
    <script src="{{ asset('js/back-navigation.js') }}"></script>

    <!-- Titre de la page en fonction de l'origine (Cellier ou Catalogue) -->
    <div class="px-3 pt-4 pb-28">
        <h2 class="mb-3 text-center text-xl text-[#7A1E2E]" style="font-family: 'Roboto', sans-serif;">
            {{ $source === 'cellier'
        ? "Fiche détaillée de ma bouteille"
        : "Fiche détaillée de la bouteille" }}
        </h2>

        <x-alerts />
        <!-- Section Détails -->
        <section>
            <!-- Nom de la bouteille -->
            <h3 class="mb-3 text-center text-l font-medium text-[#1A1A1A]" style="font-family: 'Roboto', sans-serif;">
                {{ $bouteille->nom }}
            </h3>
            <!-- Section Image -->
            <div class="relative mb-3 flex h-44 items-center justify-center">
                <!-- Afficher l'image ou l'image par défaut si aucune image trouvée -->
                @if ($bouteille->image)
                    <img src="{{ $bouteille->image }}" alt="{{ $bouteille->nom }}" class="max-h-full max-w-full object-contain">
                @else
                    <img src="{{ asset('images/bouteille-vide.png') }}" alt="Image par défaut"
                        class="max-h-full max-w-full object-contain">
                @endif
                <!-- Afficher la pastille de goût s'il y en a une -->
                @if ($bouteille->image_pastille)
                    <img src="{{ asset('images/pastilles/' . $bouteille->image_pastille) }}"
                        alt="{{ $bouteille->pastille_gout }}" class="absolute right-8 bottom-4 h-16 w-16 object-contain">

                @endif
            </div>
            <!-- Détails principaux-->
            @if ($bouteille->type)
                <p class="mb-1 text-left text-base font-normal text-[#1A1A1A]" style="font-family: 'Roboto', sans-serif;">
                    {{ $bouteille->type }}
                </p>
            @endif
            @if ($bouteille->pays)
                <p class="mb-1 text-left text-base font-normal text-[#1A1A1A]" style="font-family: 'Roboto', sans-serif;">
                    {{ $bouteille->pays }}
                </p>
            @endif

            <div class="mb-3 grid grid-cols-[1fr_auto_1fr] items-center text-[#1A1A1A]"
                style="font-family: 'Roboto', sans-serif;">
                <!-- Prix à gauche -->
                <div class="justify-self-start">
                    @if ($bouteille->prix !== null)
                        <p class="text-left text-base font-medium">
                            {{ number_format($bouteille->prix, 2, ',', ' ') }}$
                        </p>
                    @endif
                </div>

                <!-- Quantité centrée -->
                <div class="justify-self-center">
                    @if ($source === 'cellier' && $inventaire)
                        <div class="flex items-center gap-10">
                            @if ($inventaire->quantite == 0)
                                <form method="POST" action="{{ route('inventaires.destroy', $inventaire) }}" class="inline-flex">
                                    @csrf
                                    @method('DELETE')

                                    <button type="submit"
                                        class="bouton-supprimer flex items-center justify-center rounded border border-gray-300 px-2 py-2 text-gray-600 hover:bg-gray-100"
                                        data-confirm="Supprimer cette bouteille ?" aria-label="Supprimer la bouteille">
                                        <img src="{{ asset('images/icons/poubelle.svg') }}" alt="" aria-hidden="true"
                                            class="w-6 h-6">
                                    </button>
                                </form>
                            @else
                                <form method="POST" action="{{ route('inventaires.updateQuantite', $inventaire) }}"
                                    class="inline-flex">
                                    @csrf
                                    @method('PATCH')

                                    <input type="hidden" name="source_page" value="bouteille">
                                    <input type="hidden" name="id_bouteille" value="{{ $bouteille->id }}">
                                    <input type="hidden" name="quantite" value="{{ max(0, $inventaire->quantite - 1) }}">

                                    <button type="submit" class="flex items-center justify-center" aria-label="Diminuer la quantité"
                                        title="Diminuer la quantité">
                                        <img src="{{ asset('images/icons/cercle-moins.svg') }}" alt="moins" aria-hidden="true"
                                            class="w-10 h-10">
                                    </button>
                                </form>
                            @endif

                            <div class="min-w-[32px] text-center">
                                <span class="text-2xl font-semibold text-[#1A1A1A]">
                                    {{ $inventaire->quantite }}
                                </span>
                            </div>

                            <form method="POST" action="{{ route('inventaires.updateQuantite', $inventaire) }}"
                                class="inline-flex">
                                @csrf
                                @method('PATCH')

                                <input type="hidden" name="source_page" value="bouteille">
                                <input type="hidden" name="id_bouteille" value="{{ $bouteille->id }}">
                                <input type="hidden" name="quantite" value="{{ min(999, $inventaire->quantite + 1) }}">

                                <button type="submit" class="flex items-center justify-center"
                                    aria-label="Augmenter la quantité" title="Augmenter la quantité">
                                    <img src="{{ asset('images/icons/cercle-plus.svg') }}" alt="plus" aria-hidden="true"
                                        class="w-10 h-10">
                                </button>
                            </form>
                        </div>
                    @endif
                </div>

                <!-- Colonne vide à droite pour garder le centre -->
                <div></div>
            </div>

            @if ($source === 'cellier' && $inventaire && $inventaire->quantite == 0)
                <p class="mb-3 text-center text-xs text-red-500">
                    Cette bouteille a été bue.
                </p>
            @endif

            <!-- Détails secondaires -->
            <div class="mt-3 pt-3 border-t border-[#E0E0E0] text-left text-[#1A1A1A]"
                style="font-family: 'Roboto', sans-serif;">
                <!-- Millésime -->
                @if ($bouteille->millesime)
                    <div class="flex gap-2 mb-1 text-base">
                        <span class="font-medium">Millésime :</span>
                        <span class="flex-1 font-normal">
                            {{ $bouteille->millesime}}
                        </span>
                    </div>
                @endif

                <!-- Taux d'alcool -->
                @if ($bouteille->taux_alcool)
                    <div class="flex gap-2 mb-1 text-base">
                        <span class="font-medium">Taux d'alcool :</span>
                        <span class="flex-1 font-normal">
                            {{ $bouteille->taux_alcool ? $bouteille->taux_alcool . '%' : 'Non spécifié' }}
                        </span>
                    </div>
                @endif

                @if ($bouteille->cepage || $bouteille->format)
                    <div class="flex justify-between items-start mb-1 text-base">
                        <!-- Cépage(s) à gauche -->
                        @if ($bouteille->cepage)
                            <div class="flex gap-2 text-base">
                                <span class="font-medium">Cépage(s) :</span>
                                <span class="flex-1 font-normal">
                                    {{ $bouteille->cepage }}
                                </span>
                            </div>
                        @endif

                        <!-- Format à droite -->
                        @if ($bouteille->format)
                            <span class="text-sm font-normal">
                                {{ $bouteille->format }} ml
                            </span>
                        @endif
                    </div>
                @endif

                <!-- Description à afficher seulement s'il y en a une -->
                @if (!empty($bouteille->description))
                    <div class="flex gap-2 mb-1 text-base">
                        <span class="font-medium">Description :</span>
                        <span
                            class="flex-1 font-normal wrap-break-word whitespace-pre-line">{{ $bouteille->description }}</span>
                    </div>
                @endif
            </div>

            <!-- Section Avis -->
            <div class="mt-4 border-t border-[#E0E0E0] pt-4 font-roboto text-[#1A1A1A]">

                <!-- Avis des utilisateurs -->
                <div class="mb-4">
                    <p class="mb-1 text-sm font-medium text-[#1A1A1A]">
                        Avis des utilisateurs
                    </p>

                    @if ($nombreAvis > 0)
                        <div class="flex items-center gap-2">
                            <img src="{{ asset('images/etoiles/etoiles-' . str_replace('.', '-', round($moyenneAvis * 2) / 2) . '.svg') }}"
                                alt="Note moyenne" class="h-5 w-auto">
                            <span class="text-sm text-gray-600">
                                ({{ $nombreAvis }} avis)
                            </span>
                        </div>
                    @else
                        <p class="text-sm text-gray-600">
                            Aucun avis pour le moment.
                        </p>
                    @endif
                </div>

                <!-- Mon avis -->
                <div class="bg-white rounded-xl p-4 mt-4 border border-[#E0E0E0]">
                    <p class="flex justify-center mb-1 text-base font-medium text-[#1A1A1A]">
                        Mon avis
                    </p>

                    @if ($avisUtilisateur)
                        <div class="flex justify-center mb-2 mt-3">
                            <img src="{{ asset('images/etoiles/etoiles-' . str_replace('.', '-', round($avisUtilisateur->note * 2) / 2) . '.svg') }}"
                                alt="Ma note" class="h-8 w-auto">
                        </div>

                        @if ($avisUtilisateur->commentaire)
                            <p class="mt-2 whitespace-pre-line break-words text-sm text-gray-700">
                                {{ $avisUtilisateur->commentaire }}
                            </p>
                        @endif

                        @if ($avisUtilisateur->created_at == $avisUtilisateur->updated_at)
                            <p class="mt-2 text-xs text-gray-500">
                                Créé le {{ $avisUtilisateur->created_at->format('d/m/Y') }}
                            </p>
                        @else
                            <p class="mt-2 text-xs text-gray-500">
                                Modifié le {{ $avisUtilisateur->updated_at->format('d/m/Y') }}
                            </p>
                        @endif

                        <a href="{{ route('avis.edit', $avisUtilisateur->id) }}"
                            class="mt-4 mb-1 w-full rounded border border-gray-300 px-4 py-3 text-sm font-medium text-gray-600 hover:bg-gray-100 text-center block">
                            Modifier mon avis
                        </a>
                    @else
                        <p class="text-sm mt-3 text-gray-600">
                            Vous n'avez pas encore laissé d'avis.
                        </p>

                        <a href="{{ route('avis.create', $bouteille->id) }}"
                            class="mt-4 mb-1 w-full rounded bg-[#A83248] px-4 py-3 text-sm font-medium text-white text-center block">
                            Ajouter mon avis
                        </a>
                    @endif
                </div>

            </div>
        </section>
    </div>
@endsection