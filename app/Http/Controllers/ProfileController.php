<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Foto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function show()
    {
        $user = Auth::user();
        $photos = \App\Models\UserPhoto::where('user_id', $user->id)
            ->where('status', 'approved')
            ->latest()
            ->paginate(12);

        // Get user's like and comment counts
        $likeCount = \App\Models\FotoLike::where('user_id', $user->id)->count();
        $commentCount = \App\Models\FotoComment::where('guest_name', $user->name)->count();

        return view('profile.show', compact('user', 'photos', 'likeCount', 'commentCount'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($request->hasFile('photo')) {
            // Delete old photo if exists
            if ($user->photo && file_exists(public_path($user->photo))) {
                unlink(public_path($user->photo));
            }
            
            $file = $request->file('photo');
            $filename = 'user-' . $user->id . '-' . time() . '.' . $file->getClientOriginalExtension();
            $path = 'uploads/profiles/';
            
            if (!file_exists(public_path($path))) {
                mkdir(public_path($path), 0755, true);
            }
            
            $file->move(public_path($path), $filename);
            $validated['photo'] = $path . $filename;
        }

        $user->update($validated);

        return redirect()->route('profile.show')
            ->with('success', 'Profil berhasil diperbarui');
    }
}
