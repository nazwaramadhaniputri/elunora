<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\UserPhoto;
use App\Models\Foto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class UserPhotoController extends Controller
{
    public function index()
    {
        $pendingPhotos = UserPhoto::where('status', 'pending')
                            ->orderBy('created_at', 'desc')
                            ->paginate(10);
                            
        return view('admin.user-photos.index', compact('pendingPhotos'));
    }
    
    public function approved()
    {
        $approvedPhotos = UserPhoto::where('status', 'approved')
                            ->orderBy('created_at', 'desc')
                            ->paginate(10);
                            
        return view('admin.user-photos.approved', compact('approvedPhotos'));
    }
    
    public function rejected()
    {
        $rejectedPhotos = UserPhoto::where('status', 'rejected')
                            ->orderBy('created_at', 'desc')
                            ->paginate(10);
                            
        return view('admin.user-photos.rejected', compact('rejectedPhotos'));
    }
    
    public function show($id)
    {
        $photo = UserPhoto::with('user')->findOrFail($id);
        
        return view('admin.user-photos.show', compact('photo'));
    }
    
    public function approve(Request $request, $id)
    {
        $photo = UserPhoto::findOrFail($id);

        // Update status approved
        $photo->status = 'approved';
        if ($request->filled('admin_notes')) {
            $photo->admin_notes = $request->admin_notes;
        }
        $photo->save();

        // Jika diminta dari modal galeri, tambahkan ke galeri tersebut
        if ($request->filled('galery_id')) {
            $galeriId = (int) $request->galery_id;

            // Normalisasi path sumber dari beberapa kemungkinan lokasi
            $raw = ltrim((string)($photo->image_path ?? ''), '/');
            if (str_starts_with($raw, 'storage/')) { $raw = substr($raw, 8); }
            if (str_starts_with($raw, 'public/')) { $raw = substr($raw, 7); }
            // Kandidat sumber 1: storage/app/public
            $source = storage_path('app/public/'.$raw);
            // Kandidat sumber 2: public/storage
            if (!File::exists($source)) {
                $candidate = public_path('storage/'.$raw);
                if (File::exists($candidate)) { $source = $candidate; }
            }
            // Kandidat sumber 3: public root langsung
            if (!File::exists($source)) {
                $candidate = public_path($raw);
                if (File::exists($candidate)) { $source = $candidate; }
            }

            // Siapkan tujuan di public/uploads/galeri/user untuk menandai sumber user
            $destDir = public_path('uploads/galeri/user');
            if (!File::exists($destDir)) {
                File::makeDirectory($destDir, 0755, true);
            }
            $ext = pathinfo($source, PATHINFO_EXTENSION) ?: 'jpg';
            $destName = time().'_'.uniqid().'.'.$ext;
            $destPath = $destDir.DIRECTORY_SEPARATOR.$destName;

            if (File::exists($source)) {
                File::copy($source, $destPath);
                // Simpan record Foto untuk galeri
                Foto::create([
                    'galery_id' => $galeriId,
                    'judul' => $photo->title ?: 'Foto Galeri',
                    'file' => 'uploads/galeri/user/'.$destName,
                    'uploader_name' => optional($photo->user)->name ?: 'Pengguna',
                ]);
            }
        }

        if ($request->expectsJson() || $request->ajax()) {
            return response()->json(['success' => true]);
        }

        return redirect()->route('admin.user-photos.index')
                ->with('success', 'Foto berhasil disetujui.');
    }
    
    public function reject(Request $request, $id)
    {
        // Catatan opsional jika datang dari modal galeri
        $photo = UserPhoto::findOrFail($id);
        $photo->status = 'rejected';
        if ($request->filled('admin_notes')) {
            $photo->admin_notes = $request->admin_notes;
        }
        $photo->save();

        if ($request->expectsJson() || $request->ajax()) {
            return response()->json(['success' => true]);
        }

        return redirect()->route('admin.user-photos.index')
                ->with('success', 'Foto berhasil ditolak.');
    }
}