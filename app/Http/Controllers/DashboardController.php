<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Account;
use App\Models\Transaction;
use App\Models\Budget;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        // Obtener todas las cuentas del usuario
        $accounts = $user->accounts()->with('transactions')->get();

        // Calcular balance total
        $totalBalance = $accounts->sum('balance');

        // Obtener transacciones del mes actual
        $currentMonth = Carbon::now()->month;
        $currentYear = Carbon::now()->year;

        $monthlyTransactions = Transaction::whereHas('account', function ($query) use ($user) {
            $query->where('user_id', $user->id);
        })
        ->whereMonth('transaction_date', $currentMonth)
        ->whereYear('transaction_date', $currentYear)
        ->with(['account', 'category'])
        ->orderBy('transaction_date', 'desc')
        ->get();

        // Calcular ingresos y gastos del mes
        $monthlyIncome = $monthlyTransactions->where('type', 'income')->sum('amount');
        $monthlyExpenses = $monthlyTransactions->where('type', 'expense')->sum('amount');

        // Obtener últimas 10 transacciones
        $recentTransactions = Transaction::whereHas('account', function ($query) use ($user) {
            $query->where('user_id', $user->id);
        })
        ->with(['account', 'category'])
        ->orderBy('transaction_date', 'desc')
        ->limit(10)
        ->get();

        // Gastos por categoría (para el gráfico)
        $expensesByCategory = $monthlyTransactions
            ->where('type', 'expense')
            ->groupBy('category_id')
            ->map(function ($transactions) {
                return [
                    'category' => $transactions->first()->category->name,
                    'total' => $transactions->sum('amount'),
                    'color' => $transactions->first()->category->color,
                ];
            })
            ->values();

        return Inertia::render('Dashboard', [
            'accounts' => $accounts,
            'totalBalance' => $totalBalance,
            'monthlyIncome' => $monthlyIncome,
            'monthlyExpenses' => $monthlyExpenses,
            'recentTransactions' => $recentTransactions,
            'expensesByCategory' => $expensesByCategory,
        ]);
    }
}
