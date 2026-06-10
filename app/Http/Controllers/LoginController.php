<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\Hash;
use App\Models\Cashiers;

class LoginController extends Controller
{
    /**
     * Menampilkan halaman form login
     */
    public function showLoginForm(): View
    {
        return view('auth.login');
    }

    /**
     * Proses login: cek username & password, simpan session
     */
    public function login(Request $request)
    {
        $request->validate([
            'username' => ['required', 'string'],
            'password' => ['required', 'string'],
        ], [
            'username.required' => 'Username tidak boleh kosong.',
            'password.required' => 'Password tidak boleh kosong.',
        ]);

        // Cari kasir berdasarkan username
        $cashier = Cashiers::where('username', $request->username)->first();

        // Cek apakah kasir ada dan password cocok
        if (!$cashier || !Hash::check($request->password, $cashier->password)) {
            return back()
                ->withInput(['username' => $request->username])
                ->withErrors(['login' => 'Username atau password salah.']);
        }

        // Simpan data kasir ke session
        session([
            'cashier_id'   => $cashier->id,
            'cashier_name' => $cashier->name,
        ]);

        return redirect()->route('pos.index');
    }

    /**
     * Proses logout: hapus session, redirect ke login
     */
    public function logout(Request $request)
    {
        $request->session()->forget(['cashier_id', 'cashier_name']);
        return redirect()->route('login');
    }
}