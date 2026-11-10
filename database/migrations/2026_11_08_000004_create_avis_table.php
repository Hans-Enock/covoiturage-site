<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('avis', function (Blueprint $table) {
            $table->increments('id_avis');
            $table->unsignedInteger('id_trajet');
            $table->unsignedInteger('id_auteur');
            $table->unsignedInteger('id_cible');
            $table->unsignedTinyInteger('note');
            $table->text('commentaire')->nullable();
            $table->dateTime('date')->useCurrent();

            $table->unique(['id_trajet', 'id_auteur', 'id_cible']);
            $table->foreign('id_trajet')->references('id_trajet')->on('trajets');
            $table->foreign('id_auteur')->references('id_user')->on('users');
            $table->foreign('id_cible')->references('id_user')->on('users');
        });

        DB::statement('ALTER TABLE avis ADD CONSTRAINT avis_pas_auto_avis CHECK (id_auteur <> id_cible)');
        DB::statement('ALTER TABLE avis ADD CONSTRAINT avis_note_valide CHECK (note BETWEEN 1 AND 5)');
    }

    public function down(): void
    {
        Schema::dropIfExists('avis');
    }
};