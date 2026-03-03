<?php

namespace App\Http\Controllers;

use App\Models\Colocation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ColocationController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
        ]);

        $colocation = Colocation::create([
            'name' => $validated['title'],
            'status' => 'active',
            'owner_id' => Auth::user()->id,
        ]);

        $colocation->members()->attach(Auth::user()->id, ['role' => 'owner']);

        return redirect()->route('dashboard');
    }

    public function show(Colocation $colocation)
    {
        $colocation->load(['members', 'expenses.user']);
        return view('colocation.show', compact('colocation'));
    }

    public function destroy(Colocation $colocation)
    {
        if (Auth::user()->id !== $colocation->owner_id) {
            abort(403);
        }

        $colocation->delete();

        return redirect()->route('dashboard');
    }

    public function index()
    {
        $colocations = Auth::user()->Colocations;

        return view('dashboard', compact('colocations'));
    }

    public function invite(Request $request, Colocation $colocation)
    {
        // Guard: only owner can invite
        if (Auth::id() !== $colocation->owner_id) {
            abort(403);
        }

        $validated = $request->validate([
            'email' => 'required|email|exists:users,email'
        ], [
            'email.exists' => 'No user found with this email address.'
        ]);

        $user = \App\Models\User::where('email', $validated['email'])->first();

        // Check if user is already a member
        if ($colocation->members->contains($user->id)) {
            return back()->withErrors(['email' => 'This user is already a member of your flatshare.']);
        }

        $colocation->members()->attach($user->id, ['role' => 'member']);

        return back()->with('success', 'User ' . $user->name . ' has been added successfully!');
    }
}
