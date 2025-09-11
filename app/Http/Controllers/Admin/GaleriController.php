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
        $galeris = Galeri::with(['post', 'fotos'])->latest()->paginate(10);
        return view('admin.galeri.index', compact('galeris'));
    }

    public function create()
    {
        $posts = Post::where('status', 'published')->get();
        return view('admin.galeri.create', compact('posts'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'post_id' => 'nullable|exists:posts,id',
            'judul' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'position' => 'required|integer|min:0',
            'status' => 'required|in:0,1',
        ]);

        $galeri = Galeri::create([
            'post_id' => $request->post_id,
            'judul' => $request->judul,
            'deskripsi' => $request->deskripsi ?? 'Deskripsi galeri',
            'position' => $request->position,
            'status' => $request->status,
        ]);

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Galeri berhasil dibuat',
                'galeri' => $galeri
            ]);
        }

        return redirect()->route('admin.galeri.index')->with('success', 'Galeri berhasil ditambahkan');
    }

    public function show($id)
    {
        $galeri = Galeri::with(['post', 'fotos'])->findOrFail($id);
        return view('admin.galeri.show', compact('galeri'));
    }

    public function edit($id)
    {
        $galeri = Galeri::findOrFail($id);
        $posts = Post::where('status', 'published')->get();
        return view('admin.galeri.edit', compact('galeri', 'posts'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'post_id' => 'nullable|exists:posts,id',
            'judul' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'position' => 'required|integer|min:0',
            'status' => 'required|in:0,1',
        ]);

        $galeri = Galeri::findOrFail($id);
        $galeri->update([
            'post_id' => $request->post_id,
            'judul' => $request->judul,
            'deskripsi' => $request->deskripsi ?? 'Deskripsi galeri',
            'position' => $request->position,
            'status' => $request->status,
        ]);

        return redirect()->route('admin.galeri.index')->with('success', 'Galeri berhasil diperbarui');
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
}
