<?php
// Debug script to check gallery data
require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "=== DEBUGGING GALLERY ISSUE ===\n\n";

// Check database connection
try {
    $galleries = \App\Models\Galeri::with(['post', 'fotos'])->get();
    echo "Total galleries in database: " . $galleries->count() . "\n\n";
    
    foreach ($galleries as $gallery) {
        echo "Gallery ID: " . $gallery->id . "\n";
        echo "Title: " . $gallery->judul . "\n";
        echo "Status: " . $gallery->status . " (" . ($gallery->status ? 'Active' : 'Inactive') . ")\n";
        echo "Post ID: " . $gallery->post_id . "\n";
        echo "Post exists: " . ($gallery->post ? 'Yes - ' . $gallery->post->judul : 'No') . "\n";
        echo "Photos count: " . $gallery->fotos->count() . "\n";
        
        if ($gallery->fotos->count() > 0) {
            echo "First photo: " . $gallery->fotos->first()->file . "\n";
        }
        echo "---\n";
    }
    
    echo "\n=== ACTIVE GALLERIES (status = 1) ===\n";
    $activeGalleries = \App\Models\Galeri::where('status', 1)->with(['post', 'fotos'])->get();
    echo "Active galleries count: " . $activeGalleries->count() . "\n\n";
    
    foreach ($activeGalleries as $gallery) {
        echo "Active Gallery: " . $gallery->judul . " (ID: " . $gallery->id . ")\n";
        echo "Photos: " . $gallery->fotos->count() . "\n";
    }
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
