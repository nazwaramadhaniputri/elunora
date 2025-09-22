<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Galeri;
use App\Models\Profile;
use App\Models\Kategori;

class HomeController extends Controller
{
    public function index()
    {
        $posts = Post::where('status', 'published')->orderBy('updated_at', 'desc')->take(3)->get();
        $galeris = Galeri::where('status', 1)->latest()->take(3)->get();
        $profile = Profile::first();
        
        // Get upcoming agendas (next 3 upcoming events) — status 1 = published
        $upcomingAgendas = \App\Models\Agenda::where('status', 1)
            ->where('tanggal', '>=', now()->format('Y-m-d'))
            ->orderBy('tanggal', 'asc')
            ->orderBy('waktu_mulai', 'asc')
            ->take(3)
            ->get();
        
        return view('home', compact('posts', 'galeris', 'profile', 'upcomingAgendas'));
    }
    
    public function berita()
    {
        $posts = Post::where('status', 'published')->with('kategori')->paginate(9);
        $kategoris = Kategori::all();
        
        return view('berita', compact('posts', 'kategoris'));
    }
    
    public function beritaDetail($id)
    {
        $post = Post::where('status', 'published')->with('kategori')->findOrFail($id);
        $relatedPosts = Post::where('status', 'published')
            ->with('kategori')
            ->where('kategori_id', $post->kategori_id)
            ->where('id', '!=', $id)
            ->take(3)
            ->get();
            
        return view('berita-detail', compact('post', 'relatedPosts'));
    }
    
    public function galeri()
    {
        $galeris = Galeri::where('status', 1)->with('fotos')->paginate(12);
        
        return view('galeri', compact('galeris'));
    }
    
    public function galeriDetail($id)
    {
        $galeri = Galeri::where('status', 1)->with('fotos')->findOrFail($id);
        
        return view('galeri-detail', compact('galeri'));
    }
    
    public function profil()
    {
        $profile = Profile::first();
        $fasilitas = \App\Models\Fasilitas::where('status', 1)->orderBy('urutan')->get();
        $gurus = \App\Models\Guru::where('status', 1)->orderBy('urutan')->get();
        
        return view('profil', compact('profile', 'fasilitas', 'gurus'));
    }
    
    public function kontak()
    {
        $profile = Profile::first();
        
        return view('kontak', compact('profile'));
    }
    
    public function kirimPesan(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'subjek' => 'required|string|max:255',
            'pesan' => 'required|string',
        ]);
        
        // Simpan pesan ke database
        \App\Models\Contact::create([
            'nama' => $request->nama,
            'email' => $request->email,
            'subjek' => $request->subjek,
            'pesan' => $request->pesan,
            'status' => 0 // belum dibaca
        ]);
        
        return back()->with('success', 'Pesan Anda telah terkirim. Terima kasih!');
    }

    public function fasilitasAll()
    {
        $fasilitas = \App\Models\Fasilitas::where('status', 1)
                                         ->orderBy('urutan', 'asc')
                                         ->paginate(12);
        
        return view('fasilitas-all', compact('fasilitas'));
    }

    public function guruAll()
    {
        $gurus = \App\Models\Guru::where('status', 1)
                                ->orderBy('nama', 'asc')
                                ->paginate(12);
        
        return view('guru-all', compact('gurus'));
    }
}
