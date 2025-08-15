<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Str;
use App\Models\User;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $key = 'login-attempts:' . $request->ip();
        
        if (RateLimiter::tooManyAttempts($key, 5)) {
            $seconds = RateLimiter::availableIn($key);
            throw ValidationException::withMessages([
                'email' => ['Muitas tentativas de login. Tente novamente em ' . ceil($seconds/60) . ' minutos.'],
            ]);
        }

        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string|min:6',
        ]);

        $credentials = $request->only('email', 'password');

        if (auth()->attempt($credentials, $request->filled('remember'))) {
            RateLimiter::clear($key);
            
            $request->session()->regenerate();
            
            return redirect()->route('dashboard');
        }

        RateLimiter::hit($key, 300);

        return back()->withErrors(['email' => 'Credenciais inválidas'])->onlyInput('email');
    }

    public function showRegisterForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $key = 'register-attempts:' . $request->ip();
        
        if (RateLimiter::tooManyAttempts($key, 3)) {
            $seconds = RateLimiter::availableIn($key);
            throw ValidationException::withMessages([
                'email' => ['Muitas tentativas de registro. Tente novamente em ' . ceil($seconds/60) . ' minutos.'],
            ]);
        }

        $request->validate([
            'name' => 'required|string|max:255|min:2|regex:/^[a-zA-ZÀ-ÿ\s]+$/',
            'email' => 'required|email|unique:users|max:255',
            'password' => [
                'required',
                'string',
                'min:8',
                'confirmed',
                'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/'
            ],
        ], [
            'name.regex' => 'O nome deve conter apenas letras e espaços.',
            'name.min' => 'O nome deve ter pelo menos 2 caracteres.',
            'password.regex' => 'A senha deve conter pelo menos: 1 letra minúscula, 1 maiúscula e 1 número.',
            'password.min' => 'A senha deve ter pelo menos 8 caracteres.',
        ]);

        $disposableEmails = ['10minutemail.com', 'guerrillamail.com', 'mailinator.com'];
        $emailDomain = substr(strrchr($request->email, "@"), 1);
        
        if (in_array($emailDomain, $disposableEmails)) {
            return back()->withErrors(['email' => 'Email temporário não é permitido.'])->onlyInput('name');
        }

        User::create([
            'name' => trim($request->name),
            'email' => strtolower($request->email),
            'password' => Hash::make($request->password),
        ]);

        RateLimiter::hit($key, 3600);

        return redirect()->route('login')->with('success', 'Conta criada com sucesso!');
    }

    public function logout(Request $request)
    {
        auth()->logout();
        
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect()->route('login')->with('success', 'Você saiu da conta.');
    }
}