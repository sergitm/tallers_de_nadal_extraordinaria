<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginLogoutController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        //
        if (Auth::check()) {
            Auth::logout();
            $request->session()->invalidate();
 
            $request->session()->regenerateToken();
            return redirect(route('home'));
        } else {
            return view('login');
        }
    }
}
