<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('fotos', function (Blueprint $table) {
            if (!Schema::hasColumn('fotos', 'likes_count')) {
                $table->unsignedBigInteger('likes_count')->default(0)->after('judul');
            }
        });
    }

    public function down(): void
    {
        Schema::table('fotos', function (Blueprint $table) {
            if (Schema::hasColumn('fotos', 'likes_count')) {
                $table->dropColumn('likes_count');
            }
        });
    }
};
