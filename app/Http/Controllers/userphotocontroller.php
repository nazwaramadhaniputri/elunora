<?php

namespace App\Http\Controllers;

use App\Models\UserPhoto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class UserPhotoController extends Controller
{
    public function index()
    {
        $photos = UserPhoto::where('status', 'approved')
                    ->orderBy('created_at', 'desc')
                    ->paginate(12);
                    
        return view('user-photos.index', compact('photos'));
    }
    
    public function myPhotos()
    {
        $photos = UserPhoto::where('user_id', Auth::id())
                    ->orderBy('created_at', 'desc')
                    ->paginate(12);
                    
        return view('user-photos.my-photos', compact('photos'));
    }
    
    public function create()
    {
        return view('user-photos.create');
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        
        $imagePath = $request->file('image')->store('user-photos', 'public');
        
        UserPhoto::create([
            'user_id' => Auth::id(),
            'title' => ($request->title ?? '') === null ? '' : trim((string)$request->title),
            'description' => $request->description ?: null,
            'image_path' => $imagePath,
            'status' => 'pending',
        ]);
        
        return back()->with('success', 'Foto berhasil diunggah dan sedang menunggu persetujuan admin.');
    }
    
    public function show($id)
    {
        $photo = UserPhoto::findOrFail($id);
        
        // Hanya tampilkan foto yang disetujui atau milik pengguna saat ini
        if ($photo->status !== 'approved' && $photo->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }
        
        return view('user-photos.show', compact('photo'));
    }
    
    public function edit($id)
    {
        $photo = UserPhoto::findOrFail($id);
        
        // Hanya pemilik foto yang dapat mengedit
        if ($photo->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }
        
        // Foto yang sudah disetujui atau ditolak tidak dapat diedit
        if ($photo->status !== 'pending') {
            return redirect()->route('user-photos.my-photos')
                    ->with('error', 'Foto yang sudah diproses tidak dapat diedit.');
        }
        
        return view('user-photos.edit', compact('photo'));
    }
    
    public function update(Request $request, $id)
    {
        $photo = UserPhoto::findOrFail($id);
        
        // Hanya pemilik foto yang dapat mengedit
        if ($photo->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }
        
        // Foto yang sudah disetujui atau ditolak tidak dapat diedit
        if ($photo->status !== 'pending') {
            return redirect()->route('user-photos.my-photos')
                    ->with('error', 'Foto yang sudah diproses tidak dapat diedit.');
        }
        
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        
        $data = [
            'title' => ($request->title ?? '') === null ? '' : trim((string)$request->title),
            'description' => $request->description,
        ];
        
        if ($request->hasFile('image')) {
            // Hapus gambar lama
            Storage::disk('public')->delete($photo->image_path);
            
            // Simpan gambar baru
            $data['image_path'] = $request->file('image')->store('user-photos', 'public');
        }
        
        $photo->update($data);
        
        return back()->with('success', 'Foto berhasil diperbarui.');
    }
    
    public function destroy($id)
    {
        $photo = UserPhoto::findOrFail($id);
        
        // Hanya pemilik foto yang dapat menghapus
        if ($photo->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }
        
        // Hapus gambar dari storage
        Storage::disk('public')->delete($photo->image_path);
        
        // Hapus data dari database
        $photo->delete();
        
        return redirect()->route('user-photos.my-photos')
                ->with('success', 'Foto berhasil dihapus.');
    }
}