<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            // Gastos
            ['name' => 'Comida y Restaurantes', 'type' => 'expense', 'icon' => '🍔', 'color' => '#EF4444'],
            ['name' => 'Transporte', 'type' => 'expense', 'icon' => '🚗', 'color' => '#F59E0B'],
            ['name' => 'Vivienda', 'type' => 'expense', 'icon' => '🏠', 'color' => '#8B5CF6'],
            ['name' => 'Servicios', 'type' => 'expense', 'icon' => '💡', 'color' => '#3B82F6'],
            ['name' => 'Entretenimiento', 'type' => 'expense', 'icon' => '🎮', 'color' => '#EC4899'],
            ['name' => 'Salud', 'type' => 'expense', 'icon' => '⚕️', 'color' => '#10B981'],
            ['name' => 'Educación', 'type' => 'expense', 'icon' => '📚', 'color' => '#6366F1'],
            ['name' => 'Compras', 'type' => 'expense', 'icon' => '🛍️', 'color' => '#F97316'],
            ['name' => 'Otros Gastos', 'type' => 'expense', 'icon' => '💸', 'color' => '#6B7280'],

            // Ingresos
            ['name' => 'Salario', 'type' => 'income', 'icon' => '💰', 'color' => '#10B981'],
            ['name' => 'Freelance', 'type' => 'income', 'icon' => '💼', 'color' => '#059669'],
            ['name' => 'Inversiones', 'type' => 'income', 'icon' => '📈', 'color' => '#34D399'],
            ['name' => 'Otros Ingresos', 'type' => 'income', 'icon' => '💵', 'color' => '#6EE7B7'],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
