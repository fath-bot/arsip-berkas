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
 * @property string|null $jenis_barang
 * @property Carbon|null $tanggal_masuk
 * @property Carbon|null $tanggal_kembali
 * @property string|null $alasan
 * @property string|null $status
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @property Collection|Transaksi[] $transaksis
 *
 * @package App\Models
 */
class Transaksi extends Model
{
    use HasFactory;

	protected $table = 'transaksis';

	protected $fillable = [
		'jenis_berkas',
        'tanggal_masuk',
		'tanggal_kembali',
        'alasan',
		'status'
	];

	public function transaksi()
	{
		return $this->hasMany(Transaksi::class);
	}
    public function index()
{
    $transaksiCount = Transaksi::count();
    return view('admin.dashboard', compact('transaksiCount'));
}
    }
