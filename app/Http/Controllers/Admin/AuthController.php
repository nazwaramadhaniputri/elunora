<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Petugas;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('admin.auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $petugas = Petugas::where('email', $credentials['email'])->first();

        if ($petugas && Hash::check($credentials['password'], $petugas->password)) {
            Auth::guard('petugas')->login($petugas, $request->has('remember'));
            $request->session()->regenerate();
            return redirect()->intended(route('admin.dashboard'));
        }

        return back()->withErrors([
            'email' => 'Email atau password yang Anda masukkan salah.',
        ])->withInput($request->only('email', 'remember'));
    }

    public function logout(Request $request)
    {
        Auth::guard('petugas')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.login');
    }

    public function showForgotPasswordForm()
    {
        return view('admin.auth.forgot-password');
    }

    public function forgotPassword(Request $request)
    {
        $request->validate([
            'username' => 'required',
        ]);

        // Dalam aplikasi nyata, ini akan mengirim email reset password
        // Untuk contoh ini, kita hanya menampilkan pesan sukses

        return back()->with('status', 'Link reset password telah dikirim ke email Anda.');
    }

    public function showResetPasswordForm($token)
    {
        return view('admin.auth.reset-password', ['token' => $token]);
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required|confirmed|min:8',
            'token' => 'required',
        ]);

        // Dalam aplikasi nyata, ini akan memverifikasi token dan mengubah password
        // Untuk contoh ini, kita hanya menampilkan pesan sukses

        return redirect()->route('admin.login')->with('status', 'Password berhasil diubah.');
    }
}
