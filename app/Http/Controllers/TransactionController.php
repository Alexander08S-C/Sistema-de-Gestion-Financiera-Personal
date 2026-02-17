<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\Account;
use App\Models\Category;
use Illuminate\Http\Request;
use Inertia\Inertia;

class TransactionController extends Controller
{
    public function index(Request $request)
    {
        $transactions = Transaction::whereHas('account', function ($query) use ($request) {
            $query->where('user_id', $request->user()->id);
        })
        ->with(['account', 'category'])
        ->orderBy('transaction_date', 'desc')
        ->paginate(20);

        return Inertia::render('Transactions/Index', [
            'transactions' => $transactions,
        ]);
    }

    public function create(Request $request)
    {
        $accounts = $request->user()->accounts;
        $categories = Category::all();

        return Inertia::render('Transactions/Create', [
            'accounts' => $accounts,
            'categories' => $categories,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'account_id' => 'required|exists:accounts,id',
            'category_id' => 'required|exists:categories,id',
            'type' => 'required|in:income,expense',
            'amount' => 'required|numeric|min:0.01',
            'description' => 'nullable|string|max:500',
            'transaction_date' => 'required|date',
        ]);

        // Verificar que la cuenta pertenece al usuario
        $account = Account::findOrFail($validated['account_id']);
        if ($account->user_id !== $request->user()->id) {
            abort(403);
        }

        // Crear la transacción
        Transaction::create($validated);

        // Actualizar el balance de la cuenta
        if ($validated['type'] === 'income') {
            $account->balance += $validated['amount'];
        } else {
            $account->balance -= $validated['amount'];
        }
        $account->save();

        return redirect()->route('dashboard')->with('success', 'Transacción creada exitosamente');
    }

    public function edit(Request $request, Transaction $transaction)
    {
        // Verificar que la transacción pertenece al usuario
        if ($transaction->account->user_id !== $request->user()->id) {
            abort(403);
        }

        $accounts = $request->user()->accounts;
        $categories = Category::all();

        return Inertia::render('Transactions/Edit', [
            'transaction' => $transaction->load(['account', 'category']),
            'accounts' => $accounts,
            'categories' => $categories,
        ]);
    }

    public function update(Request $request, Transaction $transaction)
    {
        // Verificar que la transacción pertenece al usuario
        if ($transaction->account->user_id !== $request->user()->id) {
            abort(403);
        }

        $validated = $request->validate([
            'account_id' => 'required|exists:accounts,id',
            'category_id' => 'required|exists:categories,id',
            'type' => 'required|in:income,expense',
            'amount' => 'required|numeric|min:0.01',
            'description' => 'nullable|string|max:500',
            'transaction_date' => 'required|date',
        ]);

        // Verificar que la nueva cuenta también pertenece al usuario
        $newAccount = Account::findOrFail($validated['account_id']);
        if ($newAccount->user_id !== $request->user()->id) {
            abort(403);
        }

        // Revertir el balance de la cuenta original
        $oldAccount = $transaction->account;
        if ($transaction->type === 'income') {
            $oldAccount->balance -= $transaction->amount;
        } else {
            $oldAccount->balance += $transaction->amount;
        }
        $oldAccount->save();

        // Actualizar la transacción
        $transaction->update($validated);

        // Aplicar el nuevo balance
        if ($validated['type'] === 'income') {
            $newAccount->balance += $validated['amount'];
        } else {
            $newAccount->balance -= $validated['amount'];
        }
        $newAccount->save();

        return redirect()->route('transactions.index')->with('success', 'Transacción actualizada exitosamente');
    }

    public function destroy(Request $request, Transaction $transaction)
    {
        // Verificar que la transacción pertenece al usuario
        if ($transaction->account->user_id !== $request->user()->id) {
            abort(403);
        }

        // Revertir el balance de la cuenta
        $account = $transaction->account;
        if ($transaction->type === 'income') {
            $account->balance -= $transaction->amount;
        } else {
            $account->balance += $transaction->amount;
        }
        $account->save();

        // Eliminar la transacción
        $transaction->delete();

        return redirect()->route('transactions.index')->with('success', 'Transacción eliminada exitosamente');
    }
}
