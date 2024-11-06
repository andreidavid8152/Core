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
        Schema::create('receta_ingrediente', function (Blueprint $table) {
            $table->id();

            // Clave foránea hacia la tabla recetas
            $table->foreignId('receta_id')
                ->constrained('recetas')
                ->onDelete('cascade'); // Elimina solo la relación si se elimina la receta

            // Clave foránea hacia la tabla ingredientes
            $table->foreignId('ingrediente_id')
            ->constrained('ingredientes')
            ->onDelete('restrict'); // Evita eliminar ingredientes que están en uso en una receta

            // Campos adicionales de la relación
            $table->integer('cantidad');
            $table->string('unidadMedida');
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('receta_ingrediente');
    }
};
