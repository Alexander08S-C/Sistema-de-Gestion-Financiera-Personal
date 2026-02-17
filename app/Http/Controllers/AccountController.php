<?php

namespace App\Http\Controllers;

use App\Models\Account;
use Illuminate\Http\Request;
use Inertia\Inertia;

class AccountController extends Controller
{
    public function index(Request $request)
    {
        $accounts = $request->user()->accounts()->with('transactions')->get();

        return Inertia::render('Accounts/Index', [
            'accounts' => $accounts,
        ]);
    }

    public function create()
    {
        return Inertia::render('Accounts/Create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:checking,savings,credit_card,cash',
            'balance' => 'required|numeric',
            'currency' => 'required|string|size:3',
            'color' => 'required|string',
        ]);

        $request->user()->accounts()->create($validated);

        return redirect()->route('dashboard')->with('success', 'Cuenta creada exitosamente');
    }

    public function edit(Request $request, Account $account)
    {
        if ($account->user_id !== $request->user()->id) {
            abort(403);
        }

        return Inertia::render('Accounts/Edit', [
            'account' => $account,
        ]);
    }

    public function update(Request $request, Account $account)
    {
        if ($account->user_id !== $request->user()->id) {
            abort(403);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:checking,savings,credit_card,cash',
            'balance' => 'required|numeric',
            'currency' => 'required|string|size:3',
            'color' => 'required|string',
        ]);

        $account->update($validated);

        return redirect()->route('accounts.index')->with('success', 'Cuenta actualizada exitosamente');
    }

    public function destroy(Request $request, Account $account)
    {
        if ($account->user_id !== $request->user()->id) {
            abort(403);
        }

        $account->delete();

        return redirect()->route('accounts.index')->with('success', 'Cuenta eliminada exitosamente');
    }
}
