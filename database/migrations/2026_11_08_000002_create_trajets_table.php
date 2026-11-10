<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('trajets', function (Blueprint $table) {
            $table->increments('id_trajet');
            $table->unsignedInteger('id_conducteur');
            $table->unsignedInteger('id_vehicule');
            $table->string('origine', 100);
            $table->string('destination', 100);
            $table->dateTime('date_heure');
            $table->unsignedTinyInteger('places_totales');
            $table->unsignedInteger('prix');
            $table->boolean('paiement_especes')->default(true);
            $table->boolean('paiement_momo')->default(false);
            $table->string('statut', 20)->default('Ouvert');

            $table->index(['statut', 'date_heure']);
            $table->foreign('id_conducteur')->references('id_user')->on('users');
            $table->foreign('id_vehicule')->references('id_vehicule')->on('vehicules');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('trajets');
    }
};