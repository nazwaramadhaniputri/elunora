<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Hitung jumlah berita
        $totalBerita = \App\Models\Post::count();
        
        // Hitung jumlah galeri
        $totalGaleri = \App\Models\Galeri::count();
        
        // Hitung jumlah foto
        $totalFoto = \App\Models\Foto::count();
        
        // Hitung jumlah kategori
        $totalKategori = \App\Models\Kategori::count();
        
        // Ambil informasi sekolah
        $profilSekolah = \App\Models\Profile::first();
        
        return view('admin.dashboard.index', compact('totalBerita', 'totalGaleri', 'totalFoto', 'totalKategori', 'profilSekolah'));
    }
}
