<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('foto_comments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('foto_id');
            $table->text('content');
            $table->string('guest_name')->nullable();
            $table->string('guest_ip', 45)->nullable();
            $table->timestamps();

            $table->foreign('foto_id')->references('id')->on('fotos')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('foto_comments');
    }
};
