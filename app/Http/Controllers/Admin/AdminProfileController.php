<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminProfileController extends Controller
{
    public function edit()
    {
        $user = auth('petugas')->user();
        if (!$user) {
            return redirect()->route('admin.login');
        }
        return view('admin.account.profile', compact('user'));
    }

    public function update(Request $request)
    {
        $user = auth('petugas')->user();
        if (!$user) {
            return redirect()->route('admin.login');
        }

        $validated = $request->validate([
            'username' => ['required','string','max:255'],
            'email'    => ['required','email','max:255'],
        ]);

        // Apply only provided fields
        if (array_key_exists('username', $validated)) {
            $user->username = $validated['username'];
        }
        if (array_key_exists('email', $validated)) {
            $user->email = $validated['email'];
        }

        $user->save();

        return redirect()->route('admin.account.profile')->with('success', 'Profil berhasil diperbarui.');
    }
}
