<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class IngredienteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Lista de ingredientes realistas
        $ingredientes = [
            'Tomate',
            'Cebolla',
            'Ajo',
            'Pimiento',
            'Zanahoria',
            'Papa',
            'Pollo',
            'Carne de Res',
            'Pescado',
            'Camarones',
            'Queso',
            'Leche',
            'Huevos',
            'Mantequilla',
            'Harina',
            'Azúcar',
            'Sal',
            'Pimienta',
            'Aceite de Oliva',
            'Vinagre',
            'Arroz',
            'Frijoles',
            'Lentejas',
            'Albahaca',
            'Perejil',
            'Cilantro',
            'Orégano',
            'Laurel',
            'Canela',
            'Vainilla',
            'Chocolate',
            'Manzana',
            'Plátano',
            'Naranja',
            'Limón',
            'Fresa',
            'Uvas',
            'Almendras',
            'Nueces',
            'Miel'
        ];

        // Insertar los ingredientes en la base de datos
        foreach ($ingredientes as $ingrediente) {
            DB::table('ingredientes')->insert([
                'nombre' => $ingrediente,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
