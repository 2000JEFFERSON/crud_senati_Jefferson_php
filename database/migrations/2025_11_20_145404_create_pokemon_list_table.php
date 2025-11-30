<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    //php artisan migrate
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pokemon_list', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique(); // El nombre del Pokémon (debe ser único)
            $table->string('url'); // La URL de detalle de la API
            $table->string('image'); // URL de la imagen normal
            $table->string('imageS'); // URL de la imagen shiny
            // Añadir otras columnas si las necesitas
            $table->timestamps(); // Columnas 'created_at' y 'updated_at'
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pokemon_list');
    }
};
