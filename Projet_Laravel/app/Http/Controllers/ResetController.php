<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ResetController extends Controller
{
    public function reset(Request $request)
    {

        return view('reset');
    }
}
