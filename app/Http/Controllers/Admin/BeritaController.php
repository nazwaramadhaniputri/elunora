<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Kategori;
use Illuminate\Support\Str;
use App\Models\Comment;

class BeritaController extends Controller
{
    public function index()
    {
        $posts = Post::with('kategori')->latest()->paginate(10);
        return view('admin.berita.index', compact('posts'));
    }

    public function create()
    {
        $kategoris = Kategori::all();
        return view('admin.berita.create', compact('kategoris'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'isi' => 'required|string',
            'kategori_id' => 'required|exists:kategoris,id',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Create uploads directory if it doesn't exist
        if (!file_exists(public_path('uploads/berita'))) {
            mkdir(public_path('uploads/berita'), 0755, true);
        }

        $gambarPath = null;
        if ($request->hasFile('gambar')) {
            $gambar = $request->file('gambar');
            $gambarName = time() . '_' . uniqid() . '.' . $gambar->getClientOriginalExtension();
            $gambar->move(public_path('uploads/berita'), $gambarName);
            $gambarPath = 'uploads/berita/' . $gambarName;
        }

        Post::create([
            'judul' => $request->judul,
            'isi' => $request->isi,
            'kategori_id' => $request->kategori_id,
            'petugas_id' => auth('petugas')->id() ?? 1,
            'status' => 'published',
            'gambar' => $gambarPath,
        ]);

        return redirect()->route('admin.berita.index')->with('success', 'Berita berhasil ditambahkan');
    }

    public function show($id)
    {
        $post = Post::with('kategori')->findOrFail($id);
        return view('admin.berita.show', compact('post'));
    }

    public function edit($id)
    {
        $post = Post::findOrFail($id);
        $kategoris = Kategori::all();
        return view('admin.berita.edit', compact('post', 'kategoris'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'isi' => 'required|string',
            'kategori_id' => 'required|exists:kategoris,id',
            'status' => 'required|in:draft,published',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $post = Post::findOrFail($id);
        
        // Create uploads directory if it doesn't exist
        if (!file_exists(public_path('uploads/berita'))) {
            mkdir(public_path('uploads/berita'), 0755, true);
        }
        
        $gambarPath = $post->gambar;
        if ($request->hasFile('gambar')) {
            // Delete old image if exists
            if ($post->gambar && file_exists(public_path($post->gambar))) {
                unlink(public_path($post->gambar));
            }
            
            $gambar = $request->file('gambar');
            $gambarName = time() . '_' . uniqid() . '.' . $gambar->getClientOriginalExtension();
            $gambar->move(public_path('uploads/berita'), $gambarName);
            $gambarPath = 'uploads/berita/' . $gambarName;
        }

        $post->update([
            'judul' => $request->judul,
            'isi' => $request->isi,
            'kategori_id' => $request->kategori_id,
            'status' => $request->status,
            'gambar' => $gambarPath,
        ]);

        return redirect()->route('admin.berita.index')->with('success', 'Berita berhasil diperbarui');
    }

    public function destroy($id)
    {
        $post = Post::findOrFail($id);
        
        // Delete associated image if exists
        if ($post->gambar && file_exists(public_path($post->gambar))) {
            unlink(public_path($post->gambar));
        }
        
        $post->delete();

        return redirect()->route('admin.berita.index')->with('success', 'Berita berhasil dihapus');
    }

    public function deleteComment(Comment $comment)
    {
        $postId = $comment->post_id;
        $comment->delete();
        if ($postId) {
            return redirect()->route('admin.berita.show', $postId)->with('success', 'Komentar berhasil dihapus.');
        }
        return back()->with('success', 'Komentar berhasil dihapus.');
    }

    // Kategori methods
    public function kategoriIndex()
    {
        $kategoris = Kategori::withCount('posts')->get();
        return view('admin.kategori.index', compact('kategoris'));
    }

    public function kategoriCreate()
    {
        return view('admin.kategori.create');
    }

    public function kategoriStore(Request $request)
    {
        $request->validate([
            'nama_kategori' => 'required|string|max:255|unique:kategoris',
        ]);

        Kategori::create([
            'nama_kategori' => $request->nama_kategori,
        ]);

        return redirect()->route('admin.berita.kategori.index')->with('success', 'Kategori berhasil ditambahkan');
    }

    public function kategoriEdit($id)
    {
        $kategori = Kategori::findOrFail($id);
        return view('admin.kategori.edit', compact('kategori'));
    }

    public function kategoriUpdate(Request $request, $id)
    {
        $request->validate([
            'nama_kategori' => 'required|string|max:255|unique:kategoris,nama_kategori,' . $id,
        ]);

        $kategori = Kategori::findOrFail($id);
        $kategori->update([
            'nama_kategori' => $request->nama_kategori,
        ]);

        return redirect()->route('admin.berita.kategori.index')->with('success', 'Kategori berhasil diperbarui');
    }

    public function kategoriDestroy($id)
    {
        $kategori = Kategori::findOrFail($id);
        
        if ($kategori->posts()->count() > 0) {
            return redirect()->route('admin.berita.kategori.index')->with('error', 'Kategori tidak dapat dihapus karena masih digunakan oleh berita');
        }

        $kategori->delete();
        return redirect()->route('admin.berita.kategori.index')->with('success', 'Kategori berhasil dihapus');
    }
}
