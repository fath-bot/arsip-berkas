<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Arsip extends Model
{
    use HasFactory;

    protected $table = 'arsip';

    protected $fillable = [
    'user_id',
    'arsip_jenis_id',
    'keterangan_arsip',
    'nomor_arsip',
    'nama_arsip',
    'file_path',
    'letak_berkas',
    'tanggal_upload'
];


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function jenis()
    {
        return $this->belongsTo(ArsipJenis::class, 'arsip_jenis_id');
    }

    public function transaksis()
    {
        return $this->hasMany(Transaksi::class);
    }
}