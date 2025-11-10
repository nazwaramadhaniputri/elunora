<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Schema\Blueprint;

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

// Check if timestamps columns exist
$hasCreatedAt = Schema::hasColumn('posts', 'created_at');
$hasUpdatedAt = Schema::hasColumn('posts', 'updated_at');

echo "Checking posts table structure...\n";
echo "- created_at column: " . ($hasCreatedAt ? "EXISTS" : "MISSING") . "\n";
echo "- updated_at column: " . ($hasUpdatedAt ? "EXISTS" : "MISSING") . "\n";

if (!$hasCreatedAt || !$hasUpdatedAt) {
    echo "\nAttempting to add missing timestamp columns...\n";
    try {
        Schema::table('posts', function (Blueprint $table) use ($hasCreatedAt, $hasUpdatedAt) {
            if (!$hasCreatedAt) $table->timestamp('created_at')->nullable();
            if (!$hasUpdatedAt) $table->timestamp('updated_at')->nullable();
        });
        echo "Successfully added missing timestamp columns.\n";
    } catch (\Exception $e) {
        echo "Error adding timestamp columns: " . $e->getMessage() . "\n";
    }
}

// Check fillable fields in the model
$post = new \App\Models\Post();
$fillable = $post->getFillable();
$requiredFields = ['judul', 'isi', 'kategori_id', 'petugas_id', 'status', 'gambar'];

foreach ($requiredFields as $field) {
    echo "\nChecking field '$field': ";
    if (in_array($field, $fillable)) {
        echo "OK (in fillable)";
    } else {
        echo "WARNING: Missing from fillable array";
    }
    
    if (Schema::hasColumn('posts', $field)) {
        $type = DB::getSchemaBuilder()->getColumnType('posts', $field);
        echo ", EXISTS in table (type: $type)";
    } else {
        echo ", MISSING from table";
    }
}

// Check if there are any posts with null petugas_id
$nullPetugas = DB::table('posts')->whereNull('petugas_id')->count();
if ($nullPetugas > 0) {
    echo "\n\nWARNING: Found $nullPetugas posts with NULL petugas_id. This may cause issues.";
}

// Show sample post data
echo "\n\nSample post data (first 3 posts):\n";
$posts = DB::table('posts')->select(['id', 'judul', 'kategori_id', 'petugas_id', 'status', 'created_at', 'updated_at'])->limit(3)->get();
foreach ($posts as $post) {
    echo "- ID: {$post->id}, Judul: {$post->judul}, Status: {$post->status}, Petugas ID: {$post->petugas_id}, Created: {$post->created_at}, Updated: {$post->updated_at}\n";
}

echo "\nCurrent posts table columns:\n";
$columns = Schema::getColumnListing('posts');
foreach ($columns as $column) {
    $type = DB::getSchemaBuilder()->getColumnType('posts', $column);
    $default = DB::selectOne("SHOW COLUMNS FROM posts WHERE Field = ?", [$column]);
    $default = $default->Default ?? 'NULL';
    echo "- $column ($type, default: $default)\n";
}
