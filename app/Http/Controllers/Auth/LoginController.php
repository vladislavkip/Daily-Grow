<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    // Авторизация
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended('/reviews');
        }

        return back()->withErrors([
            'email' => 'Invalid credentials',
        ])->withInput();
}

    // Выход
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }

    // Проверка текущего пользователя
    public function user(Request $request)
    {
        return $request->user() ?? response()->json(['message' => 'Unauthorized'], 401);
    }
}