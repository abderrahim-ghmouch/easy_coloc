<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Colocation;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
        $users = User::all();
        $colocations = Colocation::all();

        return view('admin.dashboard', compact('users', 'colocations'));
    }

    public function ban(User $user)
    {
        if ($user->is_admin) {
            return back()->with('error', 'Cannot ban an admin.');
        }

        $user->update(['is_banned' => true]);

        return back()->with('success', 'User banned .');
    }

    public function unban(User $user)
    {
        $user->update(['is_banned' => false]);

        return back()->with('success', 'User unbanned successfully.');
    }
}
