<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use App\Models\Post;
use Illuminate\Http\Request;

class KategoriController extends Controller
{
    public function index()
    {
        $kategoris = Kategori::withCount('posts')->get();
        $totalBerita = Post::count();
        $latestPosts = Post::latest()->take(5)->get();
        
        return view('kategori.index', compact('kategoris', 'totalBerita', 'latestPosts'));
    }
    
    public function show($id)
    {
        $kategori = Kategori::findOrFail($id);
        $posts = Post::where('kategori_id', $id)
                    ->orderBy('created_at', 'desc')
                    ->paginate(9);
                    
        return view('kategori.show', compact('kategori', 'posts'));
    }
}