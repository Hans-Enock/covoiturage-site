<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('vehicules', function (Blueprint $table) {
            $table->increments('id_vehicule');
            $table->unsignedInteger('id_user')->unique();
            $table->string('type', 20);
            $table->string('marque', 50);
            $table->string('modele', 50);
            $table->string('couleur', 30);
            $table->string('plaque', 20)->unique();
            $table->unsignedTinyInteger('nb_places');

            $table->foreign('id_user')->references('id_user')->on('users');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('vehicules');
    }
};
