<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // First, drop the columns we don't need
        Schema::table('gallery_categories', function (Blueprint $table) {
            $table->dropColumn(['slug', 'description']);
        });
        
        // Then modify the remaining columns if needed
        Schema::table('gallery_categories', function (Blueprint $table) {
            $table->string('name')->change();
            $table->boolean('status')->default(true)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Add back the columns if we need to rollback
        Schema::table('gallery_categories', function (Blueprint $table) {
            $table->string('slug')->nullable()->after('name');
            $table->text('description')->nullable()->after('slug');
        });
    }
};
