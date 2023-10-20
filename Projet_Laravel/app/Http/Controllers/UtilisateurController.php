<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class UtilisateurController extends Controller
{
    public function inscription()
    {
        return view('register');
    }

    public function connexion()
    {
        return view('login');
    }

    public function inscrit(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|max:50',
            'lastname' => 'required|max:50',
            'email' => 'required|max:255|unique:users,email',
            'password' => 'required|max:255|min:4|confirmed'
        ]);

        $validated['admin'] = 0;
        $validated['commande_en_cours'] = 1;
        $validated['password'] = Hash::make($validated['password']);

        $user=User::create($validated);
        Auth::login($user);

        return redirect('catalogue');
    }

    public function deconnexion(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('catalogue');
    }

    
    public function get_nbUsers(){
        $NBusers= User::select('*')->count('id');
        return  $NBusers;
    }
}
