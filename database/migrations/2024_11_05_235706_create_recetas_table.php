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
        Schema::create('recetas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('usuario_id'); // Relación con el usuario que creó la receta
            $table->string('titulo');
            $table->text('descripcion');
            $table->text('pasosPreparacion');
            $table->integer('caloriasConsumidas')->nullable();
            $table->timestamps();

            // Clave foránea para el usuario que crea la receta
            $table->foreign('usuario_id')->references('id')->on('usuarios')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('recetas');
    }
};
