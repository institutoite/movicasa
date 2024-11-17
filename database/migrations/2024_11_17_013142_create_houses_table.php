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
        Schema::create('houses', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description');
            $table->foreignId('category_id')->nullable()->constrained()->onDelete('set null'); // Relación con Categorías
            $table->string('address');
            $table->decimal('price', 15, 2);
            $table->integer('bedrooms');
            $table->integer('bathrooms');
            $table->double('ancho');
            $table->double('largo');
            $table->double('longitud')->nullable();
            $table->double('latitud')->nullable();
            $table->integer('garage')->default(0); // Espacios para autos
            $table->double('area'); // Metros cuadrados
            $table->boolean('is_featured')->default(false); // Propiedad destacada
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('houses');
    }
};
