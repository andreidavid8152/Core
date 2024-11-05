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
        Schema::create('preferencia_usuario', function (Blueprint $table) {
            $table->id();

            $table->foreignId('preferencia_id')
            ->constrained('preferencias')
            ->onDelete('restrict');

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
        Schema::dropIfExists('preferencia_usuario');
    }
};
