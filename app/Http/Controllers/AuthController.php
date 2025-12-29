<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // Show login form
    public function showLogin()
    {
        return view('auth.login');
    }
    
    // Handle login
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);
        
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended('/')->with('success', 'Welcome back!');
        }
        
        return back()->withErrors([
            'email' => 'Invalid credentials.',
        ])->onlyInput('email');
    }
    
    // Show register form
    public function showRegister()
    {
        return view('auth.register');
    }
    
    // Handle registration
    // Handle registration
public function register(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users',
        'password' => 'required|min:6|confirmed'
    ]);
    
    // Hardcoded admin email
    $adminEmail = 'khatrirakhi319@gmail.com';
    $isAdmin = ($request->email === $adminEmail);
    
    $user = User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => Hash::make($request->password),
        'role' => $isAdmin ? 'admin' : 'user'
    ]);
    
    Auth::login($user);
    
    $message = $isAdmin 
        ? 'Admin account created! You have full control.' 
        : 'Registration successful!';
    
    return redirect('/')->with('success', $message);
    }
    
    // Handle logout
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect('/')->with('success', 'Logged out successfully!');
    }
}