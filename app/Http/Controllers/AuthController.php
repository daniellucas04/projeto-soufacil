<?php

namespace App\Http\Controllers;

use App\Enums\ReturnMessage;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function index() {
        if (!Auth::check()) {
            return view('login');
        }

        return redirect('dashboard');
    }

    public function login(Request $request): RedirectResponse {
        $validated = $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:8'
        ]);

        if (!Auth::attempt($validated)) {
            return back()->withErrors([
                'all' => ReturnMessage::FAILED_TO_LOGIN->value,
            ])->onlyInput('email');
        }

        $request->session()->regenerate();
        return redirect()->intended('/dashboard');
    }

    public function logout(Request $request) {
        Auth::logout();

        return redirect('/');
    }
}
