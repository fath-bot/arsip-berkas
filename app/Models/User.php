<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'nip',
        'role',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // Relasi baru
    public function arsips()
    {
        return $this->hasMany(Arsip::class);
    }

    public function transaksis()
    {
        return $this->hasMany(Transaksi::class);
    }

    public function logAktivitas()
    {
        return $this->hasMany(LogAktivitas::class);
    }
}