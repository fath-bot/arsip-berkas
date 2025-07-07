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
 * @property string|null $no_sk
 * @property string|null $tanggal
 * @property Carbon|null $letak_berkas
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @property Collection|Cpns[] $cpnss
 *
 * @package App\Models
 */
class Cpns extends Model
{
    use HasFactory;

	protected $table = 'cpnss';

	protected $fillable = [
		'nama',
        'nip',
		'jabatan',
        'no_sk',
		'tanggal',
        'letak_berkas'
	];

	public function cpns()
	{
		return $this->hasMany(Cpns::class);
	}

    }
