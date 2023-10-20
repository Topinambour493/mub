<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /**
     * Handle an authentication attempt.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function authentification(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            $user=Auth::user();

            function console_log($output, $with_script_tags = true) {
                $js_code = 'console.log(' . json_encode($output, JSON_HEX_TAG) . 
            ');';
                if ($with_script_tags) {
                    $js_code = '<script>' . $js_code . '</script>';
                }
                echo $js_code;
            }

            return redirect('catalogue');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }
}