<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('usuarios', function (Blueprint $table) {
            $table->id(); // Clave primaria
            $table->string('nombre', 100);
            $table->string('email', 150)->unique();
            $table->string('contrasena');
            $table->decimal('peso', 5, 2)-> nullable(); 
            $table->decimal('altura', 4, 2)->nullable(); 
            $table->enum('sexo', ['Masculino', 'Femenino'])->nullable();
            $table->integer('edad')->nullable();
            $table->integer('caloriasPorComida')->nullable();
            $table->timestamp('fechaRegistro')->default(DB::raw('CURRENT_TIMESTAMP'));
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('usuarios');
    }
};
