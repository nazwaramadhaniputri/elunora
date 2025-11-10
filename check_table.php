<?php
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';

// Bootstrap the application
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

// Check database connection
try {
    DB::connection()->getPdo();
    echo "Connected successfully to: " . DB::connection()->getDatabaseName() . "\n";
    
    // Check if posts table exists
    if (Schema::hasTable('posts')) {
        echo "Posts table exists.\n";
        
        // Get columns
        $columns = Schema::getColumnListing('posts');
        echo "Columns in posts table: " . implode(', ', $columns) . "\n";
        
        // Get first post
        $post = DB::table('posts')->first();
        if ($post) {
            echo "First post: " . json_encode($post, JSON_PRETTY_PRINT) . "\n";
        } else {
            echo "No posts found in the database.\n";
        }
    } else {
        echo "Posts table does not exist.\n";
    }
    
} catch (\Exception $e) {
    echo "Could not connect to the database. Error: " . $e->getMessage() . "\n";
    $config = DB::connection()->getConfig();
    echo "DB Connection: " . $config['driver'] . "://" . 
         ($config['username'] ?? '') . "@" . 
         ($config['host'] ?? '') . 
         "/" . ($config['database'] ?? '') . "\n";
}
