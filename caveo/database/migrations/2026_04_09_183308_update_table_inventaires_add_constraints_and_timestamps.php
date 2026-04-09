<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Effectue la mise à jour de la table inventaires.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::table('inventaires', function (Blueprint $table) {
            /**
             * Donne une valeur par défaut à la quantité.
             */
            $table->integer('quantite')->default(1)->change();

            /**
             * Ajoute les timestamps Laravel.
             */
            $table->timestamps();
        });

        /**
         * Remplace la contrainte étrangère de id_bouteille
         * pour permettre la suppression en cascade.
         */
        Schema::table('inventaires', function (Blueprint $table) {
            $table->dropForeign(['id_bouteille']);
        });

        Schema::table('inventaires', function (Blueprint $table) {
            $table->foreign('id_bouteille')
                ->references('id')
                ->on('bouteilles')
                ->onDelete('cascade');
        });

        Schema::table('inventaires', function (Blueprint $table) {
            /**
             * Empêche d'ajouter deux fois la même bouteille dans le même cellier.
             */
            $table->unique(['id_cellier', 'id_bouteille'], 'inventaires_id_cellier_id_bouteille_unique');
        });
    }

    /**
     * Annule la mise à jour de la table inventaires.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::table('inventaires', function (Blueprint $table) {
            /**
             * Supprime la contrainte unique ajoutée dans up().
             */
            $table->dropUnique('inventaires_id_cellier_id_bouteille_unique');
        });

        Schema::table('inventaires', function (Blueprint $table) {
            /**
             * Remet la clé étrangère de id_bouteille sans suppression en cascade.
             */
            $table->dropForeign(['id_bouteille']);
        });

        Schema::table('inventaires', function (Blueprint $table) {
            $table->foreign('id_bouteille')
                ->references('id')
                ->on('bouteilles');
        });

        Schema::table('inventaires', function (Blueprint $table) {
            /**
             * Retire les timestamps.
             */
            $table->dropTimestamps();

            /**
             * Retire la valeur par défaut de quantite.
             */
            $table->integer('quantite')->default(null)->change();
        });
    }
};
