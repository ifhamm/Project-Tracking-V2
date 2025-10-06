<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    // Tampilkan halaman login
    public function showLogin()
    {
        return view('auth.login');
    }

    // Proses login
    public function login(Request $request)
    {
        $request->validate([
            'nik' => 'required',
            'password' => 'required',
        ]);

        // Cek user berdasarkan NIK
        $user = User::where('nik', $request->nik)->first();

        if (!$user) {
            return back()->withErrors(['nik' => 'NIK tidak ditemukan.'])->withInput();
        }

        // Cek password
        if (!Hash::check($request->password, $user->password)) {
            return back()->withErrors(['password' => 'Password salah.'])->withInput();
        }

        // Login manual
        Auth::login($user);

        // Redirect berdasarkan role
        switch (strtolower($user->role)) {
            case 'superadmin':
                return redirect()->route('superadmin.dashboard');
            case 'admin':
                return redirect()->route('admin.dashboard');
            case 'mechanic':
                return redirect()->route('mechanic.dashboard');
            case 'quality inspector':
                return redirect()->route('inspector.dashboard');
            case 'quality cvdr':
                return redirect()->route('cvdr.dashboard');
            default:
                return redirect()->route('home');
        }
    }

    // Logout
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login')->with('success', 'Anda telah logout.');
    }
}
