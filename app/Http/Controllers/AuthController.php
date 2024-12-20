<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    // Fungsi untuk menampilkan form login
    public function showLoginForm()
    {
        return view('login');
    }

    // Fungsi untuk proses login
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        // Cek kredensial pengguna
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $user = Auth::user();
            if($user->role == 'admin'){
                return redirect('/admin/home');
            }else{
                return redirect('/user/home');
            }
        }
        // Jika gagal, kembali ke form login dengan pesan error
        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ]);
    }

    // Fungsi untuk menampilkan form registrasi
    public function showRegisterForm()
    {
        return view('register');
    }

    // Fungsi untuk proses registrasi
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed'
        ]);

        // Buat pengguna baru
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'user', // Set role ke 'user' secara otomatis
        ]);

        // Login otomatis setelah registrasi
        Auth::login($user);

        if($user->role == 'admin'){
            return redirect('/admin/home');
        }else{
            return redirect('/user/home');
        }
    }

    // Fungsi logout
    public function logout()
    {
        Auth::logout();
        return redirect('/login')->with('status', 'Anda telah berhasil logout.');
    }

//     public function logout(Request $request)
// {
//     // Ambil role pengguna sebelum logout
//     $role = Auth::user()->role;

//     // Logout pengguna
//     Auth::logout();

//     // Invalidate sesi pengguna
//     $request->session()->invalidate();

//     // Regenerate token CSRF
//     $request->session()->regenerateToken();

//     // Redirect sesuai dengan role
//     if ($role == 'admin') {
//         return redirect('/admin/login')->with('status', 'Anda telah berhasil logout.');
//     } else {
//         return redirect('/user/login')->with('status', 'Anda telah berhasil logout.');
//     }
//     }
}
