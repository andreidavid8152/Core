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
        Schema::create('restriccion_usuario', function (Blueprint $table) {
            $table->id(); // Clave primaria

            // Clave foránea hacia la tabla restricciones
            $table->foreignId('restriccion_id')
            ->constrained('restricciones')
            ->onDelete('restrict');

            // Clave foránea hacia la tabla usuarios
            $table->foreignId('usuario_id')
                ->constrained('usuarios')
                ->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('restriccion_usuario');
    }
};
