<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\BudgetController;
use App\Http\Controllers\AiInsightController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

// Rutas protegidas (requieren autenticación)
Route::middleware('auth')->group(function () {
    // Dashboard principal
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Gestión de Cuentas
    Route::resource('accounts', AccountController::class);

    // Gestión de Transacciones
    Route::resource('transactions', TransactionController::class);

    // Gestión de Presupuestos
    Route::resource('budgets', BudgetController::class);

    // Insights de IA
    Route::get('/ai-insights', [AiInsightController::class, 'index'])->name('ai-insights.index');
    Route::post('/ai-insights/generate', [AiInsightController::class, 'generate'])->name('ai-insights.generate');
    Route::patch('/ai-insights/{aiInsight}/mark-read', [AiInsightController::class, 'markAsRead'])->name('ai-insights.mark-read');

    // Perfil de usuario
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
