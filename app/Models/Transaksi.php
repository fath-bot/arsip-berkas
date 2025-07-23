<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class Transaksi extends Model
{
    use HasFactory;

    protected $table = 'transaksis';

    protected $fillable = [
        'user_id',
        'arsip_id',
        'jenis_id',
        'tanggal_pinjam',
        'tanggal_kembali',
        'status',
        'keterangan',
        'alasan',
        'is_approved',
        'alasan_penolakan',
    ];

    protected $casts = [
        'tanggal_pinjam'  => 'date',
        'tanggal_kembali' => 'date',
        'is_approved' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function arsip()
    {
        return $this->belongsTo(Arsip::class);
    }

    public function jenis()
    {
        return $this->belongsTo(ArsipJenis::class, 'jenis_id');
    }
}
