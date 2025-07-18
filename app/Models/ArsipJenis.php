<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ArsipJenis extends Model
{
    use HasFactory;

    protected $table = 'arsip_jenis';

    protected $fillable = [
        'nama_jenis'
    ];

    public function arsips()
    {
        return $this->hasMany(Arsip::class, 'arsip_jenis_id');
    }
}