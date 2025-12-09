<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pengguna;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /**
     * Tampilkan halaman login
     */
    public function showLogin()
    {
        return view('login');
    }

    /**
     * Proses login dengan validasi lebih jelas
     */
    public function login(Request $request)
    {
        // Validasi input
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required'
        ]);

        // Cari user berdasarkan email
        $user = Pengguna::where('email', $request->email)->first();

        // Cek apakah user ada
        if (!$user) {
            // Email tidak ditemukan
            return back()->withErrors([
                'email' => 'Email tidak terdaftar',
            ])->withInput();
        }

        // Cek password
        if (!Hash::check($request->password, $user->password)) {
            // Password salah
            return back()->withErrors([
                'password' => 'Password salah',
            ])->withInput();
        }

        // Simpan session manual
        session([
            'user_id' => $user->id,
            'role'    => $user->role,
        ]);

        // Redirect sesuai role
        switch ($user->role) {
            case 'karyawan':
                return redirect()->route('Karyawan.MenuKaryawan_page');
            case 'kasir':
                return redirect()->route('Kasir.Cashier_page');
            default:
                return back()->withErrors([
                    'role' => 'Role tidak dikenal',
                ]);
        }
    }

    /**
     * Logout user
     */
    public function logout(Request $request)
    {
        $request->session()->flush();
        return redirect()->route('login.page');
    }
}
