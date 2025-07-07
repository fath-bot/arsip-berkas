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
        Schema::create('ijazahs', function (Blueprint $table) {
            $table->id();
            $table->text('nama');
            $table->text('nip');
            $table->text('jabatan');
            $table->enum('jenjang', [
                'SMA',
                'D3',
                'S1',
                'S2',
                'S3'
                ]);
            $table->text('universitas');
            $table->text('letak_berkas');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ijazahs');
    }
};
