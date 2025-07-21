<?php

namespace Database\Seeders;

use App\Models\Arsip;
use App\Models\ArsipJenis;
use App\Models\LogAktivitas;
use App\Models\Transaksi;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // Seed Users
        $admin = User::create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'nip' => '1234567890',
            'role' => 'admin',
            'password' => Hash::make('admin'),
        ]);

        $user1 = User::create([
            'name' => 'Budi Santoso',
            'email' => 'budi@example.com',
            'nip' => '198012312345678901',
            'role' => 'user',
            'password' => Hash::make('password'),
        ]);

        $user2 = User::create([
            'name' => 'Siti Rahayu',
            'email' => 'siti@example.com',
            'nip' => '198512312345678902',
            'role' => 'user',
            'password' => Hash::make('password'),
        ]);

        // Seed Arsip Jenis
        $jenisArsip = [
            'Ijazah',
            'SK Pangkat',
            'SK CPNS',
            'SK Jabatan',
            'SK Mutasi Unit',
            'SK Pemberhentian',
            'Sertifikasi',
            'Satya Lencana',
            'Penilaian Prestasi Kerja (SKP)',
            'lainnya'
        ];

        $jenisIds = [];
        foreach ($jenisArsip as $jenis) {
            $jenisModel = ArsipJenis::create(['nama_jenis' => $jenis]);
            $jenisIds[$jenis] = $jenisModel->id;
        }

        // Seed Arsip
        $arsipData = [
            [
                'user_id' => $user1->id,
                'arsip_jenis_id' => $jenisIds['Ijazah'],
                'nomor_arsip' => 'IJZ-2023-001',
                'nama_arsip' => 'Ijazah S1 Budi Santoso',
                'file_path' => 'ijazah/budi_s1.pdf',
                'letak_berkas' => 'Lemari A, Rak 3',
                'tanggal_upload' => '2023-06-15',
            ],
            [
                'user_id' => $user1->id,
                'arsip_jenis_id' => $jenisIds['SK Pangkat'],
                'nomor_arsip' => 'SKP-2023-001',
                'nama_arsip' => 'SK Kenaikan Pangkat Budi Santoso',
                'file_path' => 'sk_pangkat/budi_2023.pdf',
                'letak_berkas' => 'Lemari B, Rak 1',
                'tanggal_upload' => '2023-07-20',
            ],
            [
                'user_id' => $user2->id,
                'arsip_jenis_id' => $jenisIds['SK CPNS'],
                'nomor_arsip' => 'SKC-2020-001',
                'nama_arsip' => 'SK CPNS Siti Rahayu',
                'file_path' => 'sk_cpns/siti_2020.pdf',
                'letak_berkas' => 'Lemari C, Rak 2',
                'tanggal_upload' => '2020-05-10',
            ],
            [
                'user_id' => $user2->id,
                'arsip_jenis_id' => $jenisIds['Sertifikasi'],
                'nomor_arsip' => 'SER-2022-001',
                'nama_arsip' => 'Sertifikasi Kompetensi Siti Rahayu',
                'file_path' => 'sertifikasi/siti_2022.pdf',
                'letak_berkas' => 'Lemari D, Rak 4',
                'tanggal_upload' => '2022-11-30',
            ],
        ];

        foreach ($arsipData as $data) {
            Arsip::create($data);
        }

        // Seed Transaksi
        $transaksiData = [
            [
                'user_id' => $user1->id,
                'arsip_id' => 1,
                'tanggal_pinjam' => '2023-08-01',
                'tanggal_kembali' => '2023-08-10',
                'status' => 'dikembalikan',
                'keterangan' => 'Untuk keperluan pengajuan beasiswa',
                'alasan' => 'Pengajuan beasiswa pascasarjana',
            ],
            [
                'user_id' => $user2->id,
                'arsip_id' => 3,
                'tanggal_pinjam' => '2023-08-05',
                'tanggal_kembali' => null,
                'status' => 'dipinjam',
                'keterangan' => 'Untuk verifikasi administrasi',
                'alasan' => 'Verifikasi data kepegawaian',
            ],
            [
                'user_id' => $user1->id,
                'arsip_id' => 2,
                'tanggal_pinjam' => '2023-08-15',
                'tanggal_kembali' => null,
                'status' => 'belum_diambil',
                'keterangan' => 'Persyaratan kenaikan pangkat',
                'alasan' => 'Pengajuan kenaikan pangkat berikutnya',
            ],
        ];

        foreach ($transaksiData as $data) {
            Transaksi::create($data);
        }

        // Seed Log Aktivitas
        $logData = [
            [
                'user_id' => $admin->id,
                'aktivitas' => 'Membuat user baru: Budi Santoso',
            ],
            [
                'user_id' => $admin->id,
                'aktivitas' => 'Mengupload arsip: IJZ-2023-001',
            ],
            [
                'user_id' => $user1->id,
                'aktivitas' => 'Meminjam arsip: SK Kenaikan Pangkat Budi Santoso',
            ],
            [
                'user_id' => $user2->id,
                'aktivitas' => 'Meminjam arsip: SK CPNS Siti Rahayu',
            ],
        ];

        foreach ($logData as $data) {
            LogAktivitas::create($data);
        }

        $this->command->info('Database seeded successfully!');
    }
}