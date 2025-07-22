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
    ];

    /**
     * Cast atribut tanggal_pinjam dan tanggal_kembali
     * menjadi Carbon instances otomatis.
     */
    protected $casts = [
        'tanggal_pinjam'  => 'date',   // 'date' sama dengan 'datetime:Y-m-d'
        'tanggal_kembali' => 'date',
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
