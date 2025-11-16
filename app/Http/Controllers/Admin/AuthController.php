<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\RateLimiter;
use App\Models\Petugas;

class AuthController extends Controller
{
    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/admin/dashboard';


    public function showLoginForm()
    {
        if (Auth::guard('petugas')->check()) {
            return redirect()->route('admin.dashboard');
        }
        
        // Ensure we're not redirecting to the user login
        if (request()->is('admin/*')) {
            return view('admin.auth.login');
        }
        
        // If somehow we got here but the URL doesn't match, redirect to the admin login
        return redirect()->route('admin.login');
    }

    public function login(Request $request)
    {
        // Validate request
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        // Rate limiting
        $throttleKey = $this->throttleKey($request);
        if (RateLimiter::tooManyAttempts($throttleKey, 5)) {
            $seconds = RateLimiter::availableIn($throttleKey);
            return back()->withErrors([
                'email' => "Terlalu banyak percobaan login. Silakan coba lagi dalam {$seconds} detik.",
            ]);
        }

        // Attempt to authenticate
        if (Auth::guard('petugas')->attempt([
            'email' => $credentials['email'],
            'password' => $credentials['password']
        ], $request->boolean('remember'))) {
            $request->session()->regenerate();
            RateLimiter::clear($throttleKey);
            
            return $this->authenticated($request, Auth::guard('petugas')->user())
                ?: redirect()->intended($this->redirectPath())
                    ->with('success', 'Login berhasil! Selamat datang kembali.');
        }

        // If authentication fails
        RateLimiter::hit($throttleKey, 300); // 5 minutes cooldown
        
        return back()->withErrors([
            'email' => 'Email atau password yang Anda masukkan salah.',
        ])->withInput($request->only('email', 'remember'));
    }
    
    /**
     * Get the post login redirect path.
     *
     * @return string
     */
    public function redirectPath()
    {
        if (method_exists($this, 'redirectTo')) {
            return $this->redirectTo();
        }

        return property_exists($this, 'redirectTo') ? $this->redirectTo : '/admin/dashboard';
    }

    /**
     * The user has been authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  mixed  $user
     * @return mixed
     */
    protected function authenticated(Request $request, $user)
    {
        // You can add any additional logic here after successful authentication
        return null; // Return null to use the default redirect
    }

    protected function throttleKey(Request $request)
    {
        return 'login.'.$request->ip();
    }

    public function logout(Request $request)
    {
        Auth::guard('petugas')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/admin/login');
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
