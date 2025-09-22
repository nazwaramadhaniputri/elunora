<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        if (Schema::hasTable('comments')) {
            Schema::table('comments', function (Blueprint $table) {
                if (!Schema::hasColumn('comments', 'post_id')) {
                    $table->foreignId('post_id')->after('id')->constrained('posts')->onDelete('cascade');
                }
                if (!Schema::hasColumn('comments', 'name')) {
                    $table->string('name')->after('post_id');
                }
                if (!Schema::hasColumn('comments', 'email')) {
                    $table->string('email')->after('name');
                }
                if (!Schema::hasColumn('comments', 'content')) {
                    $table->text('content')->after('email');
                }
                if (!Schema::hasColumn('comments', 'created_at') && !Schema::hasColumn('comments', 'updated_at')) {
                    $table->timestamps();
                }
            });
        } else {
            // As a fallback, create the table if it somehow does not exist
            Schema::create('comments', function (Blueprint $table) {
                $table->id();
                $table->foreignId('post_id')->constrained('posts')->onDelete('cascade');
                $table->string('name');
                $table->string('email');
                $table->text('content');
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        // We won't drop columns in down to avoid destructive changes.
    }
};
