<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('arsip', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('arsip_jenis_id')->constrained('arsip_jenis')->onDelete('cascade');
            $table->string('nomor_arsip')->nullable();
            $table->string('nama_arsip');
            $table->string('file_path')->nullable();
            $table->string('letak_berkas')->nullable();
            $table->date('tanggal_upload')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('arsip');
    }
};