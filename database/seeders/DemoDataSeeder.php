<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Account;
use App\Models\Transaction;
use App\Models\Budget;
use App\Models\Category;
use Carbon\Carbon;

class DemoDataSeeder extends Seeder
{
    public function run(): void
    {
        // Buscar o crear usuario demo
        $user = User::firstOrCreate(
            ['email' => 'demo@finanzas.com'],
            [
                'name' => 'Usuario Demo',
                'password' => bcrypt('password123'),
            ]
        );

        // Crear cuentas
        $cuentaAhorros = Account::create([
            'user_id' => $user->id,
            'name' => 'Cuenta de Ahorros BCP',
            'type' => 'savings',
            'balance' => 5000.00,
            'currency' => 'PEN',
            'color' => '#10B981',
        ]);

        $tarjetaCredito = Account::create([
            'user_id' => $user->id,
            'name' => 'Tarjeta Visa Interbank',
            'type' => 'credit_card',
            'balance' => -1200.00,
            'currency' => 'PEN',
            'color' => '#EF4444',
        ]);

        $efectivo = Account::create([
            'user_id' => $user->id,
            'name' => 'Efectivo',
            'type' => 'cash',
            'balance' => 800.00,
            'currency' => 'PEN',
            'color' => '#F59E0B',
        ]);

        // Obtener categorías
        $categorias = Category::all();
        $comida = $categorias->where('name', 'Comida y Restaurantes')->first();
        $transporte = $categorias->where('name', 'Transporte')->first();
        $salario = $categorias->where('name', 'Salario')->first();
        $servicios = $categorias->where('name', 'Servicios')->first();
        $entretenimiento = $categorias->where('name', 'Entretenimiento')->first();
        $compras = $categorias->where('name', 'Compras')->first();

        // Crear transacciones del mes actual
        $transacciones = [
            // Ingresos
            [
                'account_id' => $cuentaAhorros->id,
                'category_id' => $salario->id,
                'type' => 'income',
                'amount' => 3500.00,
                'description' => 'Salario mensual',
                'transaction_date' => Carbon::now()->startOfMonth()->addDays(1),
            ],

            // Gastos de comida
            [
                'account_id' => $tarjetaCredito->id,
                'category_id' => $comida->id,
                'type' => 'expense',
                'amount' => 85.50,
                'description' => 'Supermercado Plaza Vea',
                'transaction_date' => Carbon::now()->subDays(2),
            ],
            [
                'account_id' => $efectivo->id,
                'category_id' => $comida->id,
                'type' => 'expense',
                'amount' => 45.00,
                'description' => 'Almuerzo en Pardo\'s Chicken',
                'transaction_date' => Carbon::now()->subDays(1),
            ],
            [
                'account_id' => $tarjetaCredito->id,
                'category_id' => $comida->id,
                'type' => 'expense',
                'amount' => 120.00,
                'description' => 'Cena en restaurante',
                'transaction_date' => Carbon::now()->subDays(5),
            ],

            // Gastos de transporte
            [
                'account_id' => $efectivo->id,
                'category_id' => $transporte->id,
                'type' => 'expense',
                'amount' => 50.00,
                'description' => 'Recarga tarjeta metropolitano',
                'transaction_date' => Carbon::now()->subDays(7),
            ],
            [
                'account_id' => $efectivo->id,
                'category_id' => $transporte->id,
                'type' => 'expense',
                'amount' => 25.00,
                'description' => 'Taxi Uber',
                'transaction_date' => Carbon::now()->subDays(3),
            ],

            // Servicios
            [
                'account_id' => $cuentaAhorros->id,
                'category_id' => $servicios->id,
                'type' => 'expense',
                'amount' => 120.00,
                'description' => 'Luz - Enel',
                'transaction_date' => Carbon::now()->subDays(10),
            ],
            [
                'account_id' => $cuentaAhorros->id,
                'category_id' => $servicios->id,
                'type' => 'expense',
                'amount' => 80.00,
                'description' => 'Internet - Movistar',
                'transaction_date' => Carbon::now()->subDays(10),
            ],
            [
                'account_id' => $cuentaAhorros->id,
                'category_id' => $servicios->id,
                'type' => 'expense',
                'amount' => 40.00,
                'description' => 'Netflix',
                'transaction_date' => Carbon::now()->subDays(8),
            ],

            // Entretenimiento
            [
                'account_id' => $tarjetaCredito->id,
                'category_id' => $entretenimiento->id,
                'type' => 'expense',
                'amount' => 65.00,
                'description' => 'Cine - 2 entradas',
                'transaction_date' => Carbon::now()->subDays(6),
            ],

            // Compras
            [
                'account_id' => $tarjetaCredito->id,
                'category_id' => $compras->id,
                'type' => 'expense',
                'amount' => 250.00,
                'description' => 'Ropa - Saga Falabella',
                'transaction_date' => Carbon::now()->subDays(12),
            ],
        ];

        foreach ($transacciones as $transaccion) {
            Transaction::create($transaccion);
        }

        // Crear presupuestos
        Budget::create([
            'user_id' => $user->id,
            'category_id' => $comida->id,
            'amount' => 500.00,
            'period' => 'monthly',
            'start_date' => Carbon::now()->startOfMonth(),
            'end_date' => Carbon::now()->endOfMonth(),
            'alert_enabled' => true,
            'alert_percentage' => 80,
        ]);

        Budget::create([
            'user_id' => $user->id,
            'category_id' => $transporte->id,
            'amount' => 200.00,
            'period' => 'monthly',
            'start_date' => Carbon::now()->startOfMonth(),
            'end_date' => Carbon::now()->endOfMonth(),
            'alert_enabled' => true,
            'alert_percentage' => 80,
        ]);

        Budget::create([
            'user_id' => $user->id,
            'category_id' => $entretenimiento->id,
            'amount' => 150.00,
            'period' => 'monthly',
            'start_date' => Carbon::now()->startOfMonth(),
            'end_date' => Carbon::now()->endOfMonth(),
            'alert_enabled' => true,
            'alert_percentage' => 80,
        ]);

        echo "✅ Datos de demo creados exitosamente!\n";
        echo "📧 Email: demo@finanzas.com\n";
        echo "🔑 Password: password123\n";
    }
}
