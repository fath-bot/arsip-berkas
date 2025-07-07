<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Transaksi
 *
 * @property int $id
 * @property string|null $nama
 * @property Carbon|null $nip
 * @property string|null $jabatan
 * @property string|null $jenjang
 * @property string|null $universitas
 * @property Carbon|null $letak_berkas
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @property Collection|Ijazah[] $ijazahs
 *
 * @package App\Models
 */
class Ijazah extends Model
{
    use HasFactory;

	protected $table = 'ijazahs';

	protected $fillable = [
		'nama',
        'nip',
		'jabatan',
        'jenjang',
		'universitas',
        'letak_berkas'
	];

	public function ijazah()
	{
		return $this->hasMany(Ijazah::class);
	}

    }
