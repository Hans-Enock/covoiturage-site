<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('avis', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedTinyInteger('note');
            $table->text('commentaire')->nullable();
            $table->dateTime('date')->useCurrent();
            $table->unsignedInteger('id_trajet');
            $table->unsignedInteger('id_auteur');
            $table->unsignedInteger('id_cible');

            $table->unique(['id_trajet', 'id_auteur', 'id_cible']);
            $table->foreign('id_trajet')->references('id')->on('trajets');
            $table->foreign('id_auteur')->references('id')->on('users');
            $table->foreign('id_cible')->references('id')->on('users');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('avis');
    }
};
