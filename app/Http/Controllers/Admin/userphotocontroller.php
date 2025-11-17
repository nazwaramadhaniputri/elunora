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
        // Pastikan relasi user dimuat
        $photo = UserPhoto::with('user')->findOrFail($id);

        // Update status approved
        $photo->status = 'approved';
        if ($request->filled('admin_notes')) {
            $photo->admin_notes = $request->admin_notes;
        }
        $photo->save();

        // Jika diminta dari modal galeri, tambahkan ke galeri tersebut
        if ($request->filled('galery_id')) {
            $galeriId = (int) $request->galery_id;

            // Normalisasi path sumber
            $raw = ltrim((string)($photo->image_path ?? ''), '/');
            
            // Hapus awalan path storage jika ada
            $prefixes = ['storage/', 'public/'];
            foreach ($prefixes as $prefix) {
                if (str_starts_with($raw, $prefix)) {
                    $raw = substr($raw, strlen($prefix));
                }
            }
            
            // Cari lokasi file yang benar
            $source = null;
            $possiblePaths = [
                storage_path('app/public/'.$raw),
                public_path('storage/'.$raw),
                public_path($raw),
                storage_path('app/'.$raw)
            ];
            
            foreach ($possiblePaths as $path) {
                if (File::exists($path)) {
                    $source = $path;
                    break;
                }
            }

            if ($source) {
                // Siapkan direktori tujuan
                $destDir = public_path('uploads/galeri/user');
                if (!File::exists($destDir)) {
                    File::makeDirectory($destDir, 0755, true);
                }
                
                $ext = pathinfo($source, PATHINFO_EXTENSION) ?: 'jpg';
                $destName = time().'_'.uniqid().'.'.$ext;
                $destPath = $destDir.DIRECTORY_SEPARATOR.$destName;

                if (File::copy($source, $destPath)) {
                    // Gunakan data user yang sudah diload
                    $uploaderName = $photo->user ? $photo->user->name : 'Pengguna';
                    
                    // Simpan record Foto untuk galeri
                    Foto::create([
                        'galery_id' => $galeriId,
                        'judul' => $photo->title ?: 'Foto Galeri',
                        'file' => 'uploads/galeri/user/'.$destName,
                        'uploader_name' => $uploaderName,
                    ]);
                }
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