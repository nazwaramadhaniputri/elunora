<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('galeris', function (Blueprint $table) {
            // First, update any 0 values to NULL
            DB::table('galeris')->where('post_id', 0)->update(['post_id' => null]);
            
            // Drop the existing foreign key constraint
            $table->dropForeign(['post_id']);
            
            // Make post_id nullable
            $table->unsignedBigInteger('post_id')->nullable()->change();
            
            // Add the foreign key constraint back with cascade on delete
            $table->foreign('post_id')->references('id')->on('posts')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
