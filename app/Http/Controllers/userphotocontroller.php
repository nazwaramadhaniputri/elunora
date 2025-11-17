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
        
        // Gunakan storage Laravel
        $path = $request->file('image')->store('user-photos', 'public');
        
        // Dapatkan path lengkap untuk disimpan di database
        $imagePath = 'storage/' . $path;
        
        UserPhoto::create([
            'user_id' => Auth::id(),
            'title' => ($request->title ?? '') === null ? '' : trim((string)$request->title),
            'description' => $request->description ?: null,
            'image_path' => $imagePath,  // Simpan path relatif dari public
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
        $request->validate([
            'title' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        
        $photo = UserPhoto::where('user_id', Auth::id())->findOrFail($id);
        
        // Jika ada gambar baru diupload
        if ($request->hasFile('image')) {
            // Hapus gambar lama jika ada
            if ($photo->image_path && strpos($photo->image_path, 'storage/') === 0) {
                $oldImage = str_replace('storage/', '', $photo->image_path);
                if (Storage::disk('public')->exists($oldImage)) {
                    Storage::disk('public')->delete($oldImage);
                }
            }
            
            // Simpan file baru
            $path = $request->file('image')->store('user-photos', 'public');
            $photo->image_path = 'storage/' . $path;
        }
        
        $photo->title = $request->title ?? '';
        $photo->description = $request->description ?: null;
        $photo->save();
        
        return back()->with('success', 'Foto berhasil diperbarui.');
    }
    
    public function destroy($id)
    {
        $photo = UserPhoto::where('user_id', Auth::id())->findOrFail($id);
        
        // Hapus file gambar dari storage
        if ($photo->image_path && strpos($photo->image_path, 'storage/') === 0) {
            $filePath = str_replace('storage/', '', $photo->image_path);
            if (Storage::disk('public')->exists($filePath)) {
                Storage::disk('public')->delete($filePath);
            }
        }
        
        $photo->delete();
        
        return back()->with('success', 'Foto berhasil dihapus.');
    }
}