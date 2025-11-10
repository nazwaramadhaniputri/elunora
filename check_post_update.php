<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;

// Ambil ID berita terakhir yang diupdate
$latestPost = DB::table('posts')
    ->orderBy('updated_at', 'desc')
    ->first();

if ($latestPost) {
    echo "=== POST TERAKHIR YANG DIUPDATE ===\n";
    echo "ID: " . $latestPost->id . "\n";
    echo "Judul: " . $latestPost->judul . "\n";
    echo "Status: " . $latestPost->status . "\n";
    echo "Gambar: " . ($latestPost->gambar ?? 'Tidak ada gambar') . "\n";
    echo "Dibuat: " . $latestPost->created_at . "\n";
    echo "Diperbarui: " . $latestPost->updated_at . "\n\n";
    
    // Cek apakah file gambar ada
    if ($latestPost->gambar) {
        $imagePath = public_path($latestPost->gambar);
        echo "Path gambar: " . $imagePath . "\n";
        echo "File gambar " . (file_exists($imagePath) ? "ADA" : "TIDAK ADA") . "\n";
    }
} else {
    echo "Tidak ada data post ditemukan\n";
}

// Cek apakah ada error di session
$errors = session('error');
if ($errors) {
    echo "\n=== ERROR PADA SESSION ===\n";
    print_r($errors);
}

$success = session('success');
if ($success) {
    echo "\n=== SUKSES PADA SESSION ===\n";
    print_r($success);
}
