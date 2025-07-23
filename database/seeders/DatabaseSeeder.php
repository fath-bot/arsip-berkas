<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Arsip;
use App\Models\ArsipJenis;
use App\Models\Transaksi;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // === Seeder untuk User ===
        $users = [
            ['name' => 'Super Admin', 'email' => 'superadmin@example.com', 'nip' => '199900012023001', 'role' => 'superadmin', 'password' => Hash::make('password123')],
            ['name' => 'Admin SDM', 'email' => 'admin1@example.com', 'nip' => '199900022023002', 'role' => 'admin', 'password' => Hash::make('admin')],
            ['name' => 'Admin Keuangan', 'email' => 'admin@example.com', 'nip' => '199900032023003', 'role' => 'admin', 'password' => Hash::make('admin')],
            ['name' => 'Budi Santoso', 'email' => 'budi@example.com', 'nip' => '199900042023004', 'role' => 'user', 'password' => Hash::make('password')],
            ['name' => 'Siti Rahayu', 'email' => 'siti@example.com', 'nip' => '199900052023005', 'role' => 'user', 'password' => Hash::make('password')],
        ];
        foreach ($users as $user) {
            User::create($user);
        }

        // === Seeder untuk ArsipJenis ===
        $jenisArsipList = [
            'Ijazah', 'SK Pangkat', 'SK CPNS', 'Sertifikasi', 'SK Jabatan',
            'SK Mutasi', 'SK Pemberhentian', 'Surat Tugas', 'Sertifikat Diklat', 'lainnya',
        ];
        foreach ($jenisArsipList as $jenis) {
            ArsipJenis::create(['nama_jenis' => $jenis]);
        }

        // === Seeder untuk Arsip === (dummy 100 arsip)
        $userIds = User::pluck('id')->toArray();
        $jenisIds = ArsipJenis::pluck('id')->toArray();
        for ($i = 1; $i <= 100; $i++) {
            Arsip::create([
                'nama_arsip' => 'Arsip Ke-' . $i,
                'arsip_jenis_id' => $jenisIds[array_rand($jenisIds)],
                'user_id' => $userIds[array_rand($userIds)],
                'letak_berkas' => 'Lemari ' . rand(1, 10) . ' - Rak ' . rand(1, 5),
            ]);
        }

        // === Seeder untuk Transaksi ===
        $arsipIds = Arsip::pluck('id')->toArray();
        $statusList = ['belum_diambil', 'dipinjam', 'dikembalikan'];
        $keteranganList = [
            'Untuk keperluan pengajuan beasiswa', 'Verifikasi administrasi', 'Persyaratan kenaikan pangkat',
            'Pengajuan sertifikasi ulang', 'Verifikasi data kepegawaian', 'Pengajuan kredit bank',
            'Proses mutasi kerja', 'Pengajuan pensiun', 'Pendaftaran pendidikan lanjut',
            'Pengajuan sertifikasi kompetensi', 'Proses penilaian kinerja', 'Pengajuan tunjangan kinerja',
            'Verifikasi data untuk promosi', 'Pengajuan cuti panjang', 'Proses perubahan jabatan',
        ];
        $alasanList = [
            'Pengajuan beasiswa pascasarjana', 'Verifikasi data kepegawaian', 'Pengajuan kenaikan pangkat berikutnya',
            'Sertifikasi kompetensi profesi', 'Proses mutasi antar unit kerja', 'Pengajuan pensiun dini',
            'Pendaftaran program magister', 'Renewal sertifikasi profesional', 'Penilaian kinerja tahunan',
            'Pengajuan tunjangan khusus', 'Persyaratan promosi jabatan', 'Pengajuan izin belajar',
            'Proses perubahan status kepegawaian', 'Verifikasi untuk kenaikan gaji', 'Pengajuan asuransi kesehatan',
        ];

        $transaksiData = [];
        for ($i = 1; $i <= 400; $i++) {
            $userId = $userIds[array_rand($userIds)];
            $arsipId = $arsipIds[array_rand($arsipIds)];
            $arsip = Arsip::find($arsipId);
            $jenisId = $arsip->arsip_jenis_id ?? $jenisIds[array_rand($jenisIds)];
            $tanggalPinjam = Carbon::today()->subDays(rand(1, 365));
            $status = $statusList[array_rand($statusList)];
           //tambahin status is aproved
            $isApproved = in_array($status, ['dipinjam', 'dikembalikan']);
            $tanggalKembali = null;

            if ($status === 'dikembalikan') {
                $tanggalKembali = $tanggalPinjam->copy()->addDays(rand(1, 30));
            } elseif ($status === 'dipinjam' && rand(0, 1)) {
                $tanggalKembali = $tanggalPinjam->copy()->addDays(rand(31, 60));
            }

            $transaksiData[] = [
                'user_id' => $userId,
                'arsip_id' => $arsipId,
                'jenis_id' => $jenisId,
                'status' => $status,
                 'is_approved'     => $isApproved,
                'keterangan' => $keteranganList[array_rand($keteranganList)],
                'alasan' => $alasanList[array_rand($alasanList)],
                'tanggal_pinjam' => $tanggalPinjam->format('Y-m-d'),
                'tanggal_kembali' => $tanggalKembali?->format('Y-m-d'),
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }
        Transaksi::insert($transaksiData);

        // === Seeder untuk Log Aktivitas ===
        $aktivitasList = [
            'Login ke sistem', 'Menambah arsip baru', 'Memperbarui data arsip', 'Menghapus arsip',
            'Melakukan peminjaman arsip', 'Mengembalikan arsip', 'Membatalkan peminjaman',
            'Mengubah status peminjaman', 'Menambah pengguna baru', 'Memperbarui profil pengguna',
            'Mengubah peran pengguna', 'Menghapus pengguna', 'Menambah jenis arsip baru',
            'Mengekspor data arsip', 'Mengimpor data arsip',
        ];
        $logData = [];
        for ($i = 1; $i <= 50; $i++) {
            $logData[] = [
                'user_id' => $userIds[array_rand($userIds)],
                'aktivitas' => $aktivitasList[array_rand($aktivitasList)],
                'created_at' => Carbon::now()->subDays(rand(0, 30)),
                'updated_at' => now(),
            ];
        }
        DB::table('log_aktivitas')->insert($logData);
    }
}
