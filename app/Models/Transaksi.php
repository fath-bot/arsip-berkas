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
        'tanggal_pinjam',
        'tanggal_kembali',
        'status',
        'keterangan',
        'alasan'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function arsip()
    {
        return $this->belongsTo(Arsip::class);
    }

    public function index()
    {
        $transaksiCount = Transaksi::count();
        return view('admin.dashboard', compact('transaksiCount'));
    }
}