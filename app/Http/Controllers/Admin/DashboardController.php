<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Agenda;
use Carbon\Carbon;
use Illuminate\Support\Facades\Schema;

class DashboardController extends Controller
{
    public function index()
    {
        // Hitung jumlah berita (hanya published jika ada kolom status)
        $totalBerita = \App\Models\Post::when(Schema::hasColumn('posts', 'status'), function($q){
                return $q->where('status', 1);
            })->count();
        
        // Hitung jumlah galeri aktif (status=1 jika ada)
        $totalGaleri = \App\Models\Galeri::when(Schema::hasColumn('galeris', 'status'), function($q){
                return $q->where('status', 1);
            })->count();
        
        // Hitung jumlah foto pada galeri aktif (lebih relevan ke publikasi)
        $totalFoto = \App\Models\Foto::whereHas('galeri', function($q){
                $q->when(Schema::hasColumn('galeris', 'status'), function($qq){ $qq->where('status',1); });
            })->count();
        
        // Hitung jumlah kategori berita (status=1 jika ada)
        $totalKategori = \App\Models\Kategori::when(Schema::hasColumn('kategoris', 'status'), function($q){
                return $q->where('status', 1);
            })->count();
        
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

        // Ambil 4 berita terbaru yang sudah dipublikasikan
        $latestPosts = \App\Models\Post::where('status', 'published')
                            ->orWhere('status', 1)
                            ->orderBy('created_at', 'desc')
                            ->take(4)
                            ->get();
        $latestFotos = \App\Models\Foto::whereHas('galeri', function($q){
                                $q->when(Schema::hasColumn('galeris', 'status'), function($qq){ $qq->where('status',1); });
                            })
                            ->orderByDesc('updated_at')
                            ->orderByDesc('created_at')
                            ->orderByDesc('id')
                            ->take(8)
                            ->get();
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

    // JSON endpoint for realtime polling by the dashboard
    public function latest()
    {
        $latestPosts = \App\Models\Post::when(Schema::hasColumn('posts', 'status'), function($q){
                                return $q->where('status', 1);
                            })
                            ->orderByDesc('updated_at')
                            ->orderByDesc('created_at')
                            ->orderByDesc('id')
                            ->take(5)
                            ->get(['id','judul','created_at','updated_at']);

        $latestFotos = \App\Models\Foto::whereHas('galeri', function($q){
                                $q->when(Schema::hasColumn('galeris', 'status'), function($qq){ $qq->where('status',1); });
                            })
                            ->orderByDesc('updated_at')
                            ->orderByDesc('created_at')
                            ->orderByDesc('id')
                            ->take(8)
                            ->get(['id','judul','file','created_at','updated_at']);

        $counts = [
            'berita' => \App\Models\Post::when(Schema::hasColumn('posts', 'status'), function($q){ return $q->where('status',1); })->count(),
            'galeri' => \App\Models\Galeri::when(Schema::hasColumn('galeris', 'status'), function($q){ return $q->where('status',1); })->count(),
            'foto'   => \App\Models\Foto::whereHas('galeri', function($q){ $q->when(Schema::hasColumn('galeris','status'), function($qq){ $qq->where('status',1); }); })->count(),
            'kategori' => \App\Models\Kategori::when(Schema::hasColumn('kategoris', 'status'), function($q){ return $q->where('status',1); })->count(),
        ];

        $todaysAgenda = Agenda::whereDate('tanggal', today())
                            ->orderBy('waktu_mulai')
                            ->get(['id','judul','lokasi','waktu_mulai','waktu_selesai']);

        return response()->json([
            'latestPosts' => $latestPosts,
            'latestFotos' => $latestFotos,
            'counts' => $counts,
            'todaysAgenda' => $todaysAgenda,
        ]);
    }
}
