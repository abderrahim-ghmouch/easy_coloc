<?php

namespace App\Http\Controllers;

use App\Models\Colocation;
use App\Models\Expense;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ExpenseController extends Controller
{
    /**
     * Store a newly created expense in storage.
     */
    public function store(Request $request, Colocation $colocation)
    {
        // Guard: Check if the user is a member of this colocation
        if (!$colocation->members->contains(Auth::user()->id)) {
            abort(403, 'You are not a member of this flatshare.');
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'montant' => 'required|numeric|min:0.01',
            'description' => 'nullable|string',
            'date' => 'required|date',
            'category' => 'nullable|string|max:100',
        ]);

        $expense = new Expense($validated);
        $expense->user_id = Auth::user()->id;
        $expense->colocation_id = $colocation->id;
        $expense->save();

        return redirect()->route('colocation.show', $colocation)
            ->with('success', 'Expense added successfully!');
    }
}
