<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Agenda;
use Carbon\Carbon;

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
        
        // Hitung jumlah agenda
        $totalAgenda = Agenda::count();
        $todayAgenda = Agenda::whereDate('tanggal', today())->count();
        $upcomingAgenda = Agenda::where('tanggal', '>=', today())
                               ->where('tanggal', '<=', today()->addDays(7))
                               ->count();
        
        // Ambil agenda mendatang
        $nextAgendas = Agenda::where('tanggal', '>=', today())
                            ->orderBy('tanggal')
                            ->orderBy('waktu_mulai')
                            ->take(5)
                            ->get();

        // Konten terbaru untuk dashboard
        $latestPosts = \App\Models\Post::orderByDesc('created_at')->take(5)->get();
        $latestFotos = \App\Models\Foto::orderByDesc('created_at')->take(8)->get();
        $todaysAgendaList = Agenda::whereDate('tanggal', today())
                                  ->orderBy('waktu_mulai')
                                  ->get();

        // Ambil informasi sekolah
        $profilSekolah = \App\Models\Profile::first();
        
        return view('admin.dashboard.index', compact(
            'totalBerita', 
            'totalGaleri', 
            'totalFoto', 
            'totalKategori',
            'totalAgenda',
            'todayAgenda',
            'upcomingAgenda',
            'nextAgendas',
            'profilSekolah',
            'latestPosts',
            'latestFotos',
            'todaysAgendaList'
        ));
    }
}
