<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('reservations', function (Blueprint $table) {
            $table->increments('id_reservation');
            $table->unsignedInteger('id_trajet');
            $table->unsignedInteger('id_passager');
            $table->unsignedInteger('prix');
            $table->string('statut', 20)->default('En attente');
            $table->dateTime('date_reservation')->useCurrent();

            $table->unique(['id_trajet', 'id_passager']);
            $table->foreign('id_trajet')->references('id_trajet')->on('trajets');
            $table->foreign('id_passager')->references('id_user')->on('users');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reservations');
    }
};