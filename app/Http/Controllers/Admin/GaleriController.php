<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Galeri;
use App\Models\Post;
use App\Models\Foto;

class GaleriController extends Controller
{
    public function index()
    {
        $galeris = Galeri::with(['post', 'fotos', 'category'])->latest()->paginate(10);
        return view('admin.galeri.index', compact('galeris'));
    }

    public function create()
    {
        $posts = Post::where('status', 'published')->get();
        $categories = \App\Models\GalleryCategory::where('status', true)->get();
        return view('admin.galeri.create', compact('posts', 'categories'));
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'judul' => 'required|string|max:255',
                'deskripsi' => 'nullable|string',
                'category_id' => 'required|exists:gallery_categories,id',
                'position' => 'required|integer|min:0',
                'status' => 'required|in:0,1',
                'post_id' => 'nullable|exists:posts,id',
            ], [
                'judul.required' => 'Judul galeri harus diisi',
                'category_id.required' => 'Kategori galeri harus dipilih',
                'category_id.exists' => 'Kategori yang dipilih tidak valid',
                'position.required' => 'Posisi harus diisi',
                'status.required' => 'Status harus dipilih',
                'post_id.exists' => 'Berita yang dipilih tidak valid',
            ]);

            $galeri = Galeri::create([
                'judul' => $validated['judul'],
                'deskripsi' => $validated['deskripsi'] ?? null,
                'category_id' => $validated['category_id'],
                'position' => $validated['position'],
                'status' => $validated['status'],
                'post_id' => $validated['post_id'] ?? null,
            ]);

            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Galeri berhasil dibuat',
                    'redirect' => route('admin.galeri.index')
                ]);
            }

            return redirect()->route('admin.galeri.index')
                ->with('success', 'Galeri berhasil dibuat');

        } catch (\Illuminate\Validation\ValidationException $e) {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'errors' => $e->errors(),
                    'message' => 'Validasi gagal'
                ], 422);
            }
            return back()->withErrors($e->errors())->withInput();
                
        } catch (\Exception $e) {
            \Log::error('Error creating gallery: ' . $e->getMessage());
            
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Terjadi kesalahan: ' . $e->getMessage()
                ], 500);
            }
            
            return back()->withInput()->with('error', 'Gagal membuat galeri. Silakan coba lagi.');
        }

        return redirect()->route('admin.galeri.index')->with('success', 'Galeri berhasil ditambahkan');
    }

    public function show($id)
    {
        // Eager-load fotos and comment counts
        $galeri = Galeri::with(['post', 'fotos' => function($q){
            $q->withCount('comments');
        }])->findOrFail($id);

        // Precompute like counts per foto to avoid N+1
        $fotoIds = $galeri->fotos->pluck('id')->all();
        $likeCounts = [];
        if (!empty($fotoIds)) {
            $likeCounts = \App\Models\FotoLike::whereIn('foto_id', $fotoIds)
                ->selectRaw('foto_id, COUNT(*) as c')
                ->groupBy('foto_id')
                ->pluck('c', 'foto_id')
                ->toArray();
        }

        return view('admin.galeri.show', [
            'galeri' => $galeri,
            'likeCounts' => $likeCounts,
        ]);
    }

    public function edit($id)
    {
        $galeri = Galeri::findOrFail($id);
        $posts = Post::where('status', 'published')->get();
        $categories = \App\Models\GalleryCategory::where('status', true)->get();
        return view('admin.galeri.edit', compact('galeri', 'posts', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'post_id' => 'nullable|exists:posts,id',
            'judul' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'category_id' => 'required|exists:gallery_categories,id',
            'position' => 'required|integer|min:0',
            'status' => 'required|in:0,1',
        ], [
            'judul.required' => 'Judul galeri harus diisi',
            'category_id.required' => 'Kategori galeri harus dipilih',
            'category_id.exists' => 'Kategori yang dipilih tidak valid',
            'position.required' => 'Posisi harus diisi',
            'status.required' => 'Status harus dipilih',
            'post_id.exists' => 'Berita yang dipilih tidak valid',
        ]);

        try {
            $galeri = Galeri::findOrFail($id);
            $galeri->update([
                'post_id' => $validated['post_id'] ?? null,
                'judul' => $validated['judul'],
                'deskripsi' => $validated['deskripsi'] ?? null,
                'category_id' => $validated['category_id'],
                'position' => $validated['position'],
                'status' => $validated['status'],
            ]);

            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Galeri berhasil diperbarui',
                    'redirect' => route('admin.galeri.index')
                ]);
            }

            return redirect()->route('admin.galeri.index')
                ->with('success', 'Galeri berhasil diperbarui');

        } catch (\Exception $e) {
            \Log::error('Error updating gallery: ' . $e->getMessage());
            
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Terjadi kesalahan: ' . $e->getMessage()
                ], 500);
            }
            
            return back()->withInput()->with('error', 'Gagal memperbarui galeri. Silakan coba lagi.');
        }
    }

    public function destroy($id)
    {
        $galeri = Galeri::findOrFail($id);
        
        // Hapus semua foto terkait
        foreach ($galeri->fotos as $foto) {
            if (file_exists(public_path($foto->file))) {
                unlink(public_path($foto->file));
            }
            $foto->delete();
        }
        
        $galeri->delete();

        return redirect()->route('admin.galeri.index')->with('success', 'Galeri berhasil dihapus');
    }

    public function addPhoto($id)
    {
        $galeri = Galeri::findOrFail($id);
        return view('admin.galeri.add-photo', compact('galeri'));
    }

    public function storePhoto(Request $request, $id)
    {
        $request->validate([
            'judul' => 'nullable|string|max:255',
            'file' => 'required|image|mimes:jpeg,png,jpg,gif|max:5120',
        ]);

        $galeri = Galeri::findOrFail($id);
        
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $fileName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            
            // Pastikan direktori ada
            if (!file_exists(public_path('uploads/galeri'))) {
                mkdir(public_path('uploads/galeri'), 0755, true);
            }
            
            $file->move(public_path('uploads/galeri'), $fileName);

            Foto::create([
                'galery_id' => $galeri->id,
                'judul' => $request->judul ?? 'Foto Galeri',
                'file' => 'uploads/galeri/' . $fileName,
                'uploader_name' => auth()->user()->name ?? 'Admin',
            ]);

            return redirect()->route('admin.galeri.show', $galeri->id)->with('success', 'Foto berhasil ditambahkan.');
        }

        return back()->with('error', 'Gagal mengunggah foto.');
    }

    public function updatePhoto(Request $request, $id)
    {
        $request->validate([
            'judul' => 'nullable|string|max:255',
        ]);

        $foto = Foto::findOrFail($id);
        $foto->update([
            'judul' => $request->judul ?? 'Foto Galeri',
        ]);

        return redirect()->route('admin.galeri.show', $foto->galery_id)->with('success', 'Judul foto berhasil diperbarui.');
    }

    public function deletePhoto($id)
    {
        $foto = Foto::findOrFail($id);
        $galeriId = $foto->galery_id;

        // Hapus file fisik jika ada
        if (file_exists(public_path($foto->file))) {
            unlink(public_path($foto->file));
        }

        $foto->delete();

        return redirect()->route('admin.galeri.show', $galeriId)->with('success', 'Foto berhasil dihapus.');
    }

    public function deleteComment(\App\Models\FotoComment $comment)
    {
        $foto = $comment->foto; // may be null if already detached
        $galeriId = optional($foto)->galery_id;
        $comment->delete();
        if ($galeriId) {
            return redirect()->route('admin.galeri.show', $galeriId)->with('success', 'Komentar berhasil dihapus.');
        }
        return back()->with('success', 'Komentar berhasil dihapus.');
    }
}
