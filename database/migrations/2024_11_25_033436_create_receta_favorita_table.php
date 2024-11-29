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
        Schema::create('receta_favorita', function (Blueprint $table) {
            $table->id();

            // Relación con la tabla usuarios
            $table->foreignId('usuario_id')
                ->constrained('usuarios')
                ->onDelete('cascade'); // Si se elimina el usuario, se eliminan sus favoritos

            // Relación con la tabla recetas
            $table->foreignId('receta_id')
                ->constrained('recetas')
                ->onDelete('restrict'); // Si se elimina la receta, y existen registros de la receta dentro de la tabla no se permite la eliminación

            $table->timestamps(); // Para manejar fecha de agregado a favoritos
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('receta_favorita');
    }
};
