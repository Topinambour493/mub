<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function register()
    {
        return view('register');
    }

    public function login()
    {
        return view('login');
    }

    public function registered(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|max:50',
            'lastname' => 'required|max:50',
            'email' => 'required|max:255|unique:users,email',
            'password' => 'required|max:255|min:4|confirmed'
        ]);

        $validated['admin'] = 0;
        $validated['current_order'] = 1;
        $validated['password'] = Hash::make($validated['password']);

        $user=User::create($validated);
        Auth::login($user);

        return redirect('catalog');
    }

    public function disconnect(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('catalog');
    }


    public function getNumberUser(){
        $NBusers= User::select('*')->count('id');
        return  $NBusers;
    }
}
