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

  
}

