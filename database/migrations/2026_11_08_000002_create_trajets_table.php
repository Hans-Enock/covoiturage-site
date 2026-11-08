<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('trajets', function (Blueprint $table) {
            $table->increments('id');
            $table->string('origine', 100);
            $table->string('destination', 100);
            $table->dateTime('date_heure');
            $table->unsignedTinyInteger('places_totales');
            $table->unsignedTinyInteger('places_restantes');
            $table->unsignedInteger('prix')->default(0);
            $table->string('statut', 20)->default('Ouvert');
            $table->unsignedInteger('id_conducteur');

            $table->foreign('id_conducteur')->references('id')->on('users');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('trajets');
    }
};