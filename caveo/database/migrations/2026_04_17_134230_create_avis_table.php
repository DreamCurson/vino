<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('avis', function (Blueprint $table) {
            $table->id();

            // Clés étrangères
            $table->unsignedBigInteger('id_utilisateur');
            $table->unsignedBigInteger('id_bouteille');

            // Note
            $table->decimal('note', 2, 1);
            
            // Commentaire
            $table->text('commentaire')->nullable();

            // Timestamps
            $table->timestamps();

            // Contraintes
            $table->foreign('id_utilisateur')
                ->references('id')
                ->on('utilisateurs')
                ->onDelete('cascade');

            $table->foreign('id_bouteille')
                ->references('id')
                ->on('bouteilles')
                ->onDelete('cascade');

            // L'utilisateur ne peut laisser qu'un seul avis par bouteille
            $table->unique(['id_utilisateur', 'id_bouteille']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('avis');
    }
};
