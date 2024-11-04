<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    // Menampilkan halaman login
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        // Validate input
        $validated = $request->validate([
            'login' => 'required', // Using a single field for email or username
            'password' => 'required|min:8',
        ], [
            'login.required' => 'Email atau Username wajib diisi.',
            'password.required' => 'Password wajib diisi.',
            'password.min' => 'Password harus terdiri dari minimal 8 karakter.',
        ]);
    
        // Get login input
        $login = $request->input('login');
        $remember = $request->has('remember'); // Check if remember me is checked
    
        // Check if login is via email or username
        $user = \App\Models\User::where('email', $login)
                    ->orWhere('username', $login) // Ensure there is a username column in the database
                    ->first();
    
        if (!$user) {
            // Return error if user not found
            return back()->withErrors([
                'login' => 'Email atau Username tidak terdaftar. Silakan cek kembali.',
            ]);
        }
    
        // Attempt authentication with the remember token
        $credentials = $request->only('password');
    
        if (Auth::attempt(array_merge($credentials, ['email' => $user->email]), $remember)) {
            // Redirect based on user role if login is successful
            $role = Auth::user()->role;
    
            switch ($role) {
                case 'admin':
                case 'guru':
                case 'siswa':
                case 'kepala_sekolah':
                    return redirect()->intended('dashboard');
                default:
                    Auth::logout();
                    return redirect()->intended('login')->withErrors('Role tidak dikenali.');
            }
        }
    
        // If password is incorrect
        return back()->withErrors([
            'password' => 'Password salah. Silakan coba lagi.',
        ]);
    }
    
    
    // Fungsi untuk logout
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('login');
    }
}
