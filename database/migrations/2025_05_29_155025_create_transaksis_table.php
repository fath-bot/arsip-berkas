<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('transaksis', function (Blueprint $table) {
    $table->id();
    $table->foreignId('user_id')->constrained()->onDelete('cascade');
    
    // arsip_id bisa null karena transaksi bisa tanpa arsip
    $table->foreignId('arsip_id')->nullable()->constrained('arsip')->onDelete('cascade');
    
    // Ganti ke jenis_id (relasi ke arsip_jenis)
    $table->foreignId('jenis_id')->nullable()->constrained('arsip_jenis')->onDelete('cascade');

    $table->enum('status', ['belum_diambil', 'dipinjam', 'dikembalikan']);
    $table->text('keterangan')->nullable();
    $table->text('alasan');
    $table->date('tanggal_pinjam');
    $table->date('tanggal_kembali')->nullable();
    $table->timestamps();
});

    }

    public function down(): void
    {
        Schema::dropIfExists('transaksis');
    }
};