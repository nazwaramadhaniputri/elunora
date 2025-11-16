<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('fotos', function (Blueprint $table) {
            // Check if the column exists and rename it if needed
            if (Schema::hasColumn('fotos', 'galery_id')) {
                // Check if the foreign key exists
                $foreignKeyExists = DB::select("
                    SELECT COUNT(*) as count 
                    FROM information_schema.TABLE_CONSTRAINTS 
                    WHERE CONSTRAINT_SCHEMA = DATABASE() 
                    AND TABLE_NAME = 'fotos' 
                    AND CONSTRAINT_NAME = 'fotos_galery_id_foreign'
                    AND CONSTRAINT_TYPE = 'FOREIGN KEY'
                ")[0]->count > 0;

                if ($foreignKeyExists) {
                    $table->dropForeign('fotos_galery_id_foreign');
                }
                
                $table->renameColumn('galery_id', 'galeri_id');
            }
        });

        // Re-add the foreign key with the correct column name
        if (Schema::hasColumn('fotos', 'galeri_id')) {
            Schema::table('fotos', function (Blueprint $table) {
                $table->foreign('galeri_id')
                      ->references('id')
                      ->on('galeris')
                      ->onDelete('cascade');
            });
        }
    }

    public function down()
    {
        // Drop the foreign key constraint if it exists
        if (Schema::hasColumn('fotos', 'galeri_id')) {
            Schema::table('fotos', function (Blueprint $table) {
                $table->dropForeign(['galeri_id']);
                $table->renameColumn('galeri_id', 'galery_id');
            });
        }

        // Re-add the foreign key with the old column name
        if (Schema::hasColumn('fotos', 'galery_id')) {
            Schema::table('fotos', function (Blueprint $table) {
                $table->foreign('galery_id')
                      ->references('id')
                      ->on('galeris')
                      ->onDelete('cascade');
            });
        }
    }
};
