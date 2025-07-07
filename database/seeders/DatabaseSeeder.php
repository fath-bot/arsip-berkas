<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Clear all tables first
        $this->truncateTables();

        // Seed users table
        DB::table('users')->insert([
            [
                'name' => 'Admin User',
                'email' => 'admin@example.com',
                'email_verified_at' => now(),
                'password' => Hash::make('password'),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Regular User',
                'email' => 'user@example.com',
                'email_verified_at' => now(),
                'password' => Hash::make('password'),
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);

        // Seed cache tables
        DB::table('cache')->insert([
            'key' => 'test_cache_key',
            'value' => 'test_cache_value',
            'expiration' => now()->addDay()->timestamp,
        ]);

        DB::table('cache_locks')->insert([
            'key' => 'test_lock_key',
            'owner' => 'test_owner',
            'expiration' => now()->addHour()->timestamp,
        ]);

        // Seed jobs tables
        DB::table('jobs')->insert([
            'queue' => 'default',
            'payload' => json_encode(['job' => 'test', 'data' => []]),
            'attempts' => 0,
            'available_at' => now()->timestamp,
            'created_at' => now()->timestamp,
        ]);

        DB::table('job_batches')->insert([
            'id' => 'test-batch-id',
            'name' => 'test-batch',
            'total_jobs' => 1,
            'pending_jobs' => 0,
            'failed_jobs' => 0,
            'failed_job_ids' => '[]',
            'options' => null,
            'created_at' => now()->timestamp,
            'finished_at' => now()->timestamp,
        ]);

        DB::table('failed_jobs')->insert([
            'uuid' => 'test-uuid',
            'connection' => 'database',
            'queue' => 'default',
            'payload' => json_encode(['job' => 'test', 'data' => []]),
            'exception' => 'Test exception',
            'failed_at' => now(),
        ]);

        // Seed CPNS table
        DB::table('cpnss')->insert([
            [
                'nama' => 'John Doe',
                'nip' => '198012312345678901',
                'jabatan' => 'Analis Kepegawaian',
                'no_sk' => 'SK/123/2025',
                'tanggal' => '2025-01-15',
                'letak_berkas' => 'Lemari A, Rak 1',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'Jane Smith',
                'nip' => '198512312345678902',
                'jabatan' => 'Staf Administrasi',
                'no_sk' => 'SK/124/2025',
                'tanggal' => '2025-02-20',
                'letak_berkas' => 'Lemari A, Rak 2',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);

        // Seed ijazahs table
        DB::table('ijazahs')->insert([
            [
                'nama' => 'John Doe',
                'nip' => '198012312345678901',
                'jabatan' => 'Analis Kepegawaian',
                'jenjang' => 'S1',
                'universitas' => 'Universitas Indonesia',
                'letak_berkas' => 'Lemari B, Rak 1',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'Jane Smith',
                'nip' => '198512312345678902',
                'jabatan' => 'Staf Administrasi',
                'jenjang' => 'D3',
                'universitas' => 'Universitas Gadjah Mada',
                'letak_berkas' => 'Lemari B, Rak 2',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);

        // Seed jabatans table
        DB::table('jabatans')->insert([
            [
                'nama' => 'John Doe',
                'nip' => '198012312345678901',
                'jabatan' => 'Analis Kepegawaian',
                'no_sk' => 'SK/125/2025',
                'tanggal' => '2025-03-10',
                'letak_berkas' => 'Lemari C, Rak 1',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'Jane Smith',
                'nip' => '198512312345678902',
                'jabatan' => 'Staf Administrasi',
                'no_sk' => 'SK/126/2025',
                'tanggal' => '2025-04-15',
                'letak_berkas' => 'Lemari C, Rak 2',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);

        // Seed mutasis table
        DB::table('mutasis')->insert([
            [
                'nama' => 'John Doe',
                'nip' => '198012312345678901',
                'jabatan' => 'Analis Kepegawaian',
                'no_sk' => 'SK/127/2025',
                'tanggal' => '2025-05-20',
                'letak_berkas' => 'Lemari D, Rak 1',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'Jane Smith',
                'nip' => '198512312345678902',
                'jabatan' => 'Staf Administrasi',
                'no_sk' => 'SK/128/2025',
                'tanggal' => '2025-06-25',
                'letak_berkas' => 'Lemari D, Rak 2',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);

        // Seed pangkats table
        DB::table('pangkats')->insert([
            [
                'nama' => 'John Doe',
                'nip' => '198012312345678901',
                'jabatan' => 'Analis Kepegawaian',
                'no_sk' => 'SK/129/2025',
                'tanggal' => '2025-07-30',
                'letak_berkas' => 'Lemari E, Rak 1',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'Jane Smith',
                'nip' => '198512312345678902',
                'jabatan' => 'Staf Administrasi',
                'no_sk' => 'SK/130/2025',
                'tanggal' => '2025-08-05',
                'letak_berkas' => 'Lemari E, Rak 2',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);

        // Seed pemberhentians table
        DB::table('pemberhentians')->insert([
            [
                'nama' => 'John Doe',
                'nip' => '198012312345678901',
                'jabatan' => 'Analis Kepegawaian',
                'no_sk' => 'SK/131/2025',
                'tanggal' => '2025-09-10',
                'letak_berkas' => 'Lemari F, Rak 1',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'Jane Smith',
                'nip' => '198512312345678902',
                'jabatan' => 'Staf Administrasi',
                'no_sk' => 'SK/132/2025',
                'tanggal' => '2025-10-15',
                'letak_berkas' => 'Lemari F, Rak 2',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);

        // Seed transaksis table
        DB::table('transaksis')->insert([
    ['jenis_berkas' => 'Ijazah', 'alasan' => 'Pengajuan kenaikan pangkat', 'tanggal_masuk' => '2025-01-05', 'tanggal_kembali' => '2025-01-20', 'status' => 'Sudah Dikembalikan', 'created_at' => now(), 'updated_at' => now()],
    ['jenis_berkas' => 'SK Pangkat', 'alasan' => 'Verifikasi data', 'tanggal_masuk' => '2025-01-07', 'tanggal_kembali' => '2025-01-22', 'status' => 'Belum Dikembalikan', 'created_at' => now(), 'updated_at' => now()],
    ['jenis_berkas' => 'SK CPNS', 'alasan' => 'Administrasi kepegawaian', 'tanggal_masuk' => '2025-01-10', 'tanggal_kembali' => '2025-01-25', 'status' => 'Sudah Diambil', 'created_at' => now(), 'updated_at' => now()],
    ['jenis_berkas' => 'SK Jabatan', 'alasan' => 'Pengajuan mutasi', 'tanggal_masuk' => '2025-01-12', 'tanggal_kembali' => '2025-01-27', 'status' => 'Belum Diambil', 'created_at' => now(), 'updated_at' => now()],
    ['jenis_berkas' => 'SK Mutasi Unit', 'alasan' => 'Proses rotasi pegawai', 'tanggal_masuk' => '2025-01-15', 'tanggal_kembali' => '2025-01-30', 'status' => 'Sudah Dikembalikan', 'created_at' => now(), 'updated_at' => now()],
    ['jenis_berkas' => 'SK Pemberhentian', 'alasan' => 'Proses pensiun', 'tanggal_masuk' => '2025-01-18', 'tanggal_kembali' => '2025-02-02', 'status' => 'Belum Dikembalikan', 'created_at' => now(), 'updated_at' => now()],
    ['jenis_berkas' => 'Sertifikasi', 'alasan' => 'Pengajuan sertifikasi baru', 'tanggal_masuk' => '2025-01-20', 'tanggal_kembali' => '2025-02-04', 'status' => 'Sudah Diambil', 'created_at' => now(), 'updated_at' => now()],
    ['jenis_berkas' => 'Satya Lencana', 'alasan' => 'Persyaratan penghargaan', 'tanggal_masuk' => '2025-01-22', 'tanggal_kembali' => '2025-02-06', 'status' => 'Belum Diambil', 'created_at' => now(), 'updated_at' => now()],
    ['jenis_berkas' => 'Penilaian Prestasi Kerja (SKP)', 'alasan' => 'Penilaian kinerja', 'tanggal_masuk' => '2025-01-25', 'tanggal_kembali' => '2025-02-09', 'status' => 'Sudah Dikembalikan', 'created_at' => now(), 'updated_at' => now()],
    ['jenis_berkas' => 'Ijazah', 'alasan' => 'Verifikasi ijazah', 'tanggal_masuk' => '2025-01-28', 'tanggal_kembali' => '2025-02-12', 'status' => 'Belum Dikembalikan', 'created_at' => now(), 'updated_at' => now()],
    ['jenis_berkas' => 'SK Pangkat', 'alasan' => 'Kenaikan pangkat reguler', 'tanggal_masuk' => '2025-02-01', 'tanggal_kembali' => '2025-02-16', 'status' => 'Sudah Diambil', 'created_at' => now(), 'updated_at' => now()],
    ['jenis_berkas' => 'SK CPNS', 'alasan' => 'Konversi NIP', 'tanggal_masuk' => '2025-02-03', 'tanggal_kembali' => '2025-02-18', 'status' => 'Belum Diambil', 'created_at' => now(), 'updated_at' => now()],
    ['jenis_berkas' => 'SK Jabatan', 'alasan' => 'Perubahan jabatan', 'tanggal_masuk' => '2025-02-05', 'tanggal_kembali' => '2025-02-20', 'status' => 'Sudah Dikembalikan', 'created_at' => now(), 'updated_at' => now()],
    ['jenis_berkas' => 'SK Mutasi Unit', 'alasan' => 'Mutasi antar unit', 'tanggal_masuk' => '2025-02-08', 'tanggal_kembali' => '2025-02-23', 'status' => 'Belum Dikembalikan', 'created_at' => now(), 'updated_at' => now()],
    ['jenis_berkas' => 'SK Pemberhentian', 'alasan' => 'Pemberhentian sementara', 'tanggal_masuk' => '2025-02-10', 'tanggal_kembali' => '2025-02-25', 'status' => 'Sudah Diambil', 'created_at' => now(), 'updated_at' => now()],
    ['jenis_berkas' => 'Sertifikasi', 'alasan' => 'Perpanjangan sertifikasi', 'tanggal_masuk' => '2025-02-12', 'tanggal_kembali' => '2025-02-27', 'status' => 'Belum Diambil', 'created_at' => now(), 'updated_at' => now()],
    ['jenis_berkas' => 'Satya Lencana', 'alasan' => 'Pencatatan penghargaan', 'tanggal_masuk' => '2025-02-15', 'tanggal_kembali' => '2025-03-02', 'status' => 'Sudah Dikembalikan', 'created_at' => now(), 'updated_at' => now()],
    ['jenis_berkas' => 'Penilaian Prestasi Kerja (SKP)', 'alasan' => 'Evaluasi tahunan', 'tanggal_masuk' => '2025-02-18', 'tanggal_kembali' => '2025-03-05', 'status' => 'Belum Dikembalikan', 'created_at' => now(), 'updated_at' => now()],
    ['jenis_berkas' => 'Ijazah', 'alasan' => 'Legalisasi dokumen', 'tanggal_masuk' => '2025-02-20', 'tanggal_kembali' => '2025-03-07', 'status' => 'Sudah Diambil', 'created_at' => now(), 'updated_at' => now()],
    ['jenis_berkas' => 'SK Pangkat', 'alasan' => 'Pencatatan data pribadi', 'tanggal_masuk' => '2025-02-22', 'tanggal_kembali' => '2025-03-09', 'status' => 'Belum Diambil', 'created_at' => now(), 'updated_at' => now()],
    ['jenis_berkas' => 'SK CPNS', 'alasan' => 'Verifikasi data kepegawaian', 'tanggal_masuk' => '2025-02-25', 'tanggal_kembali' => '2025-03-12', 'status' => 'Sudah Dikembalikan', 'created_at' => now(), 'updated_at' => now()],
    ['jenis_berkas' => 'SK Jabatan', 'alasan' => 'Pengajuan jabatan struktural', 'tanggal_masuk' => '2025-02-28', 'tanggal_kembali' => '2025-03-15', 'status' => 'Belum Dikembalikan', 'created_at' => now(), 'updated_at' => now()],
    ['jenis_berkas' => 'SK Mutasi Unit', 'alasan' => 'Penugasan khusus', 'tanggal_masuk' => '2025-03-03', 'tanggal_kembali' => '2025-03-18', 'status' => 'Sudah Diambil', 'created_at' => now(), 'updated_at' => now()],
    ['jenis_berkas' => 'SK Pemberhentian', 'alasan' => 'Pemberhentian dengan hormat', 'tanggal_masuk' => '2025-03-05', 'tanggal_kembali' => '2025-03-20', 'status' => 'Belum Diambil', 'created_at' => now(), 'updated_at' => now()],
    ['jenis_berkas' => 'Sertifikasi', 'alasan' => 'Sertifikasi kompetensi', 'tanggal_masuk' => '2025-03-08', 'tanggal_kembali' => '2025-03-23', 'status' => 'Sudah Dikembalikan', 'created_at' => now(), 'updated_at' => now()],
    ['jenis_berkas' => 'Satya Lencana', 'alasan' => 'Pengajuan satya lencana', 'tanggal_masuk' => '2025-03-10', 'tanggal_kembali' => '2025-03-25', 'status' => 'Belum Dikembalikan', 'created_at' => now(), 'updated_at' => now()],
    ['jenis_berkas' => 'Penilaian Prestasi Kerja (SKP)', 'alasan' => 'Penilaian periode 1', 'tanggal_masuk' => '2025-03-12', 'tanggal_kembali' => '2025-03-27', 'status' => 'Sudah Diambil', 'created_at' => now(), 'updated_at' => now()],
    ['jenis_berkas' => 'Ijazah', 'alasan' => 'Persyaratan diklat', 'tanggal_masuk' => '2025-03-15', 'tanggal_kembali' => '2025-03-30', 'status' => 'Belum Diambil', 'created_at' => now(), 'updated_at' => now()],
    ['jenis_berkas' => 'SK Pangkat', 'alasan' => 'Kenaikan pangkat pilihan', 'tanggal_masuk' => '2025-03-18', 'tanggal_kembali' => '2025-04-02', 'status' => 'Sudah Dikembalikan', 'created_at' => now(), 'updated_at' => now()],
    ['jenis_berkas' => 'SK CPNS', 'alasan' => 'Validasi data CPNS', 'tanggal_masuk' => '2025-03-20', 'tanggal_kembali' => '2025-04-04', 'status' => 'Belum Dikembalikan', 'created_at' => now(), 'updated_at' => now()],
    ['jenis_berkas' => 'SK Jabatan', 'alasan' => 'Penyesuaian jabatan', 'tanggal_masuk' => '2025-03-22', 'tanggal_kembali' => '2025-04-06', 'status' => 'Sudah Diambil', 'created_at' => now(), 'updated_at' => now()],
    ['jenis_berkas' => 'SK Mutasi Unit', 'alasan' => 'Rotasi jabatan', 'tanggal_masuk' => '2025-03-25', 'tanggal_kembali' => '2025-04-09', 'status' => 'Belum Diambil', 'created_at' => now(), 'updated_at' => now()],
    ['jenis_berkas' => 'SK Pemberhentian', 'alasan' => 'Pemberhentian tidak dengan hormat', 'tanggal_masuk' => '2025-03-28', 'tanggal_kembali' => '2025-04-12', 'status' => 'Sudah Dikembalikan', 'created_at' => now(), 'updated_at' => now()],
    ['jenis_berkas' => 'Sertifikasi', 'alasan' => 'Sertifikasi profesi', 'tanggal_masuk' => '2025-03-30', 'tanggal_kembali' => '2025-04-14', 'status' => 'Belum Dikembalikan', 'created_at' => now(), 'updated_at' => now()],
    ['jenis_berkas' => 'Satya Lencana', 'alasan' => 'Pencatatan masa kerja', 'tanggal_masuk' => '2025-04-02', 'tanggal_kembali' => '2025-04-17', 'status' => 'Sudah Diambil', 'created_at' => now(), 'updated_at' => now()],
    ['jenis_berkas' => 'Penilaian Prestasi Kerja (SKP)', 'alasan' => 'Penilaian periode 2', 'tanggal_masuk' => '2025-04-05', 'tanggal_kembali' => '2025-04-20', 'status' => 'Belum Diambil', 'created_at' => now(), 'updated_at' => now()],
    ['jenis_berkas' => 'Ijazah', 'alasan' => 'Persyaratan beasiswa', 'tanggal_masuk' => '2025-04-08', 'tanggal_kembali' => '2025-04-23', 'status' => 'Sudah Dikembalikan', 'created_at' => now(), 'updated_at' => now()],
    ['jenis_berkas' => 'SK Pangkat', 'alasan' => 'Kenaikan pangkat luar biasa', 'tanggal_masuk' => '2025-04-10', 'tanggal_kembali' => '2025-04-25', 'status' => 'Belum Dikembalikan', 'created_at' => now(), 'updated_at' => now()],
    ['jenis_berkas' => 'SK CPNS', 'alasan' => 'Pembaruan data CPNS', 'tanggal_masuk' => '2025-04-12', 'tanggal_kembali' => '2025-04-27', 'status' => 'Sudah Diambil', 'created_at' => now(), 'updated_at' => now()],
    ['jenis_berkas' => 'SK Jabatan', 'alasan' => 'Pengangkatan jabatan fungsional', 'tanggal_masuk' => '2025-04-15', 'tanggal_kembali' => '2025-04-30', 'status' => 'Belum Diambil', 'created_at' => now(), 'updated_at' => now()],
    ['jenis_berkas' => 'SK Mutasi Unit', 'alasan' => 'Penugasan proyek khusus', 'tanggal_masuk' => '2025-04-18', 'tanggal_kembali' => '2025-05-03', 'status' => 'Sudah Dikembalikan', 'created_at' => now(), 'updated_at' => now()],
    ['jenis_berkas' => 'SK Pemberhentian', 'alasan' => 'Pensiun dini', 'tanggal_masuk' => '2025-04-20', 'tanggal_kembali' => '2025-05-05', 'status' => 'Belum Dikembalikan', 'created_at' => now(), 'updated_at' => now()],
    ['jenis_berkas' => 'Sertifikasi', 'alasan' => 'Sertifikasi teknis', 'tanggal_masuk' => '2025-04-22', 'tanggal_kembali' => '2025-05-07', 'status' => 'Sudah Diambil', 'created_at' => now(), 'updated_at' => now()],
    ['jenis_berkas' => 'Satya Lencana', 'alasan' => 'Penganugerahan satya lencana', 'tanggal_masuk' => '2025-04-25', 'tanggal_kembali' => '2025-05-10', 'status' => 'Belum Diambil', 'created_at' => now(), 'updated_at' => now()],
    ['jenis_berkas' => 'Penilaian Prestasi Kerja (SKP)', 'alasan' => 'Penilaian tengah tahun', 'tanggal_masuk' => '2025-04-28', 'tanggal_kembali' => '2025-05-13', 'status' => 'Sudah Dikembalikan', 'created_at' => now(), 'updated_at' => now()],
    ['jenis_berkas' => 'Ijazah', 'alasan' => 'Verifikasi kelulusan', 'tanggal_masuk' => '2025-05-01', 'tanggal_kembali' => '2025-05-16', 'status' => 'Belum Dikembalikan', 'created_at' => now(), 'updated_at' => now()],
    ['jenis_berkas' => 'SK Pangkat', 'alasan' => 'Penyesuaian pangkat', 'tanggal_masuk' => '2025-05-03', 'tanggal_kembali' => '2025-05-18', 'status' => 'Sudah Diambil', 'created_at' => now(), 'updated_at' => now()],
    ['jenis_berkas' => 'SK CPNS', 'alasan' => 'Konfirmasi data CPNS', 'tanggal_masuk' => '2025-05-05', 'tanggal_kembali' => '2025-05-20', 'status' => 'Belum Diambil', 'created_at' => now(), 'updated_at' => now()],
    ['jenis_berkas' => 'SK Jabatan', 'alasan' => 'Pengubahan jabatan', 'tanggal_masuk' => '2025-05-08', 'tanggal_kembali' => '2025-05-23', 'status' => 'Sudah Dikembalikan', 'created_at' => now(), 'updated_at' => now()],
    ['jenis_berkas' => 'SK Mutasi Unit', 'alasan' => 'Alih tugas', 'tanggal_masuk' => '2025-05-10', 'tanggal_kembali' => '2025-05-25', 'status' => 'Belum Dikembalikan', 'created_at' => now(), 'updated_at' => now()],
    ['jenis_berkas' => 'SK Pemberhentian', 'alasan' => 'Pemberhentian atas permintaan sendiri', 'tanggal_masuk' => '2025-05-12', 'tanggal_kembali' => '2025-05-27', 'status' => 'Sudah Diambil', 'created_at' => now(), 'updated_at' => now()],
    ['jenis_berkas' => 'Sertifikasi', 'alasan' => 'Sertifikasi bidang tertentu', 'tanggal_masuk' => '2025-05-15', 'tanggal_kembali' => '2025-05-30', 'status' => 'Belum Diambil', 'created_at' => now(), 'updated_at' => now()],
    ['jenis_berkas' => 'Satya Lencana', 'alasan' => 'Pemberian tanda jasa', 'tanggal_masuk' => '2025-05-18', 'tanggal_kembali' => '2025-06-02', 'status' => 'Sudah Dikembalikan', 'created_at' => now(), 'updated_at' => now()],
    ['jenis_berkas' => 'Penilaian Prestasi Kerja (SKP)', 'alasan' => 'Penilaian akhir tahun', 'tanggal_masuk' => '2025-05-20', 'tanggal_kembali' => '2025-06-04', 'status' => 'Belum Dikembalikan', 'created_at' => now(), 'updated_at' => now()],
    ['jenis_berkas' => 'Ijazah', 'alasan' => 'Pendaftaran pendidikan lanjut', 'tanggal_masuk' => '2025-05-22', 'tanggal_kembali' => '2025-06-06', 'status' => 'Sudah Diambil', 'created_at' => now(), 'updated_at' => now()],
    ['jenis_berkas' => 'SK Pangkat', 'alasan' => 'Pencatatan pangkat terakhir', 'tanggal_masuk' => '2025-05-25', 'tanggal_kembali' => '2025-06-09', 'status' => 'Belum Diambil', 'created_at' => now(), 'updated_at' => now()],
    ['jenis_berkas' => 'SK CPNS', 'alasan' => 'Pembaruan berkas CPNS', 'tanggal_masuk' => '2025-05-28', 'tanggal_kembali' => '2025-06-12', 'status' => 'Sudah Dikembalikan', 'created_at' => now(), 'updated_at' => now()],
    ['jenis_berkas' => 'SK Jabatan', 'alasan' => 'Pengangkatan dalam jabatan', 'tanggal_masuk' => '2025-05-30', 'tanggal_kembali' => '2025-06-14', 'status' => 'Belum Dikembalikan', 'created_at' => now(), 'updated_at' => now()],
    ['jenis_berkas' => 'SK Mutasi Unit', 'alasan' => 'Penugasan lintas unit', 'tanggal_masuk' => '2025-06-02', 'tanggal_kembali' => '2025-06-17', 'status' => 'Sudah Diambil', 'created_at' => now(), 'updated_at' => now()],
    ['jenis_berkas' => 'SK Pemberhentian', 'alasan' => 'Pemberhentian karena kesehatan', 'tanggal_masuk' => '2025-06-05', 'tanggal_kembali' => '2025-06-20', 'status' => 'Belum Diambil', 'created_at' => now(), 'updated_at' => now()],
    ['jenis_berkas' => 'Sertifikasi', 'alasan' => 'Sertifikasi keahlian khusus', 'tanggal_masuk' => '2025-06-08', 'tanggal_kembali' => '2025-06-23', 'status' => 'Sudah Dikembalikan', 'created_at' => now(), 'updated_at' => now()],
    ['jenis_berkas' => 'Satya Lencana', 'alasan' => 'Penyempurnaan data penghargaan', 'tanggal_masuk' => '2025-06-10', 'tanggal_kembali' => '2025-06-25', 'status' => 'Belum Dikembalikan', 'created_at' => now(), 'updated_at' => now()],
    ['jenis_berkas' => 'Penilaian Prestasi Kerja (SKP)', 'alasan' => 'Review kinerja pegawai', 'tanggal_masuk' => '2025-06-12', 'tanggal_kembali' => '2025-06-27', 'status' => 'Sudah Diambil', 'created_at' => now(), 'updated_at' => now()],
    ['jenis_berkas' => 'Ijazah', 'alasan' => 'Persyaratan seleksi', 'tanggal_masuk' => '2025-06-15', 'tanggal_kembali' => '2025-06-30', 'status' => 'Belum Diambil', 'created_at' => now(), 'updated_at' => now()],
    ['jenis_berkas' => 'SK Pangkat', 'alasan' => 'Penyetaraan pangkat', 'tanggal_masuk' => '2025-06-18', 'tanggal_kembali' => '2025-07-03', 'status' => 'Sudah Dikembalikan', 'created_at' => now(), 'updated_at' => now()],
    ['jenis_berkas' => 'SK CPNS', 'alasan' => 'Verifikasi akhir data CPNS', 'tanggal_masuk' => '2025-06-20', 'tanggal_kembali' => '2025-07-05', 'status' => 'Belum Dikembalikan', 'created_at' => now(), 'updated_at' => now()],
    ['jenis_berkas' => 'SK Jabatan', 'alasan' => 'Peninjauan jabatan', 'tanggal_masuk' => '2025-06-22', 'tanggal_kembali' => '2025-07-07', 'status' => 'Sudah Diambil', 'created_at' => now(), 'updated_at' => now()],
    ['jenis_berkas' => 'SK Mutasi Unit', 'alasan' => 'Penugasan sementara', 'tanggal_masuk' => '2025-06-25', 'tanggal_kembali' => '2025-07-10', 'status' => 'Belum Diambil', 'created_at' => now(), 'updated_at' => now()],
    ['jenis_berkas' => 'SK Pemberhentian', 'alasan' => 'Pemberhentian karena pelanggaran', 'tanggal_masuk' => '2025-06-28', 'tanggal_kembali' => '2025-07-13', 'status' => 'Sudah Dikembalikan', 'created_at' => now(), 'updated_at' => now()],
    ['jenis_berkas' => 'Sertifikasi', 'alasan' => 'Evaluasi sertifikasi', 'tanggal_masuk' => '2025-06-30', 'tanggal_kembali' => '2025-07-15', 'status' => 'Belum Dikembalikan', 'created_at' => now(), 'updated_at' => now()],
    ['jenis_berkas' => 'Satya Lencana', 'alasan' => 'Pembaruan data penghargaan', 'tanggal_masuk' => '2025-07-02', 'tanggal_kembali' => '2025-07-17', 'status' => 'Sudah Diambil', 'created_at' => now(), 'updated_at' => now()],
    ['jenis_berkas' => 'Penilaian Prestasi Kerja (SKP)', 'alasan' => 'Assesmen kinerja', 'tanggal_masuk' => '2025-07-05', 'tanggal_kembali' => '2025-07-20', 'status' => 'Belum Diambil', 'created_at' => now(), 'updated_at' => now()],
    ['jenis_berkas' => 'Ijazah', 'alasan' => 'Administrasi lamaran', 'tanggal_masuk' => '2025-07-08', 'tanggal_kembali' => '2025-07-23', 'status' => 'Sudah Dikembalikan', 'created_at' => now(), 'updated_at' => now()],
    ['jenis_berkas' => 'SK Pangkat', 'alasan' => 'Pencatatan riwayat pangkat', 'tanggal_masuk' => '2025-07-10', 'tanggal_kembali' => '2025-07-25', 'status' => 'Belum Dikembalikan', 'created_at' => now(), 'updated_at' => now()],
    ['jenis_berkas' => 'SK CPNS', 'alasan' => 'Finalisasi data CPNS', 'tanggal_masuk' => '2025-07-12', 'tanggal_kembali' => '2025-07-27', 'status' => 'Sudah Diambil', 'created_at' => now(), 'updated_at' => now()],
    ['jenis_berkas' => 'SK Jabatan', 'alasan' => 'Penyesuaian tugas jabatan', 'tanggal_masuk' => '2025-07-15', 'tanggal_kembali' => '2025-07-30', 'status' => 'Belum Diambil', 'created_at' => now(), 'updated_at' => now()],
    ['jenis_berkas' => 'SK Mutasi Unit', 'alasan' => 'Rotasi internal', 'tanggal_masuk' => '2025-07-18', 'tanggal_kembali' => '2025-08-02', 'status' => 'Sudah Dikembalikan', 'created_at' => now(), 'updated_at' => now()],
    ['jenis_berkas' => 'SK Pemberhentian', 'alasan' => 'Pemberhentian karena usia', 'tanggal_masuk' => '2025-07-20', 'tanggal_kembali' => '2025-08-04', 'status' => 'Belum Dikembalikan', 'created_at' => now(), 'updated_at' => now()],
    ['jenis_berkas' => 'Sertifikasi', 'alasan' => 'Validasi sertifikasi', 'tanggal_masuk' => '2025-07-22', 'tanggal_kembali' => '2025-08-06', 'status' => 'Sudah Diambil', 'created_at' => now(), 'updated_at' => now()],
    ['jenis_berkas' => 'Satya Lencana', 'alasan' => 'Verifikasi penghargaan', 'tanggal_masuk' => '2025-07-25', 'tanggal_kembali' => '2025-08-09', 'status' => 'Belum Diambil', 'created_at' => now(), 'updated_at' => now()],
    ['jenis_berkas' => 'Penilaian Prestasi Kerja (SKP)', 'alasan' => 'Evaluasi kinerja pegawai', 'tanggal_masuk' => '2025-07-28', 'tanggal_kembali' => '2025-08-12', 'status' => 'Sudah Dikembalikan', 'created_at' => now(), 'updated_at' => now()],
    ['jenis_berkas' => 'Ijazah', 'alasan' => 'Verifikasi dokumen pendidikan', 'tanggal_masuk' => '2025-07-30', 'tanggal_kembali' => '2025-08-14', 'status' => 'Belum Dikembalikan', 'created_at' => now(), 'updated_at' => now()],
    ['jenis_berkas' => 'SK Pangkat', 'alasan' => 'Pembaruan data pangkat', 'tanggal_masuk' => '2025-08-02', 'tanggal_kembali' => '2025-08-17', 'status' => 'Sudah Diambil', 'created_at' => now(), 'updated_at' => now()],
    ['jenis_berkas' => 'SK CPNS', 'alasan' => 'Audit data CPNS', 'tanggal_masuk' => '2025-08-05', 'tanggal_kembali' => '2025-08-20', 'status' => 'Belum Diambil', 'created_at' => now(), 'updated_at' => now()],
    ['jenis_berkas' => 'SK Jabatan', 'alasan' => 'Review jabatan struktural', 'tanggal_masuk' => '2025-08-08', 'tanggal_kembali' => '2025-08-23', 'status' => 'Sudah Dikembalikan', 'created_at' => now(), 'updated_at' => now()],
    ['jenis_berkas' => 'SK Mutasi Unit', 'alasan' => 'Penugasan khusus proyek', 'tanggal_masuk' => '2025-08-10', 'tanggal_kembali' => '2025-08-25', 'status' => 'Belum Dikembalikan', 'created_at' => now(), 'updated_at' => now()],
    ['jenis_berkas' => 'SK Pemberhentian', 'alasan' => 'Pemberhentian karena mutasi', 'tanggal_masuk' => '2025-08-12', 'tanggal_kembali' => '2025-08-27', 'status' => 'Sudah Diambil', 'created_at' => now(), 'updated_at' => now()],
    ['jenis_berkas' => 'Sertifikasi', 'alasan' => 'Pembaruan sertifikasi', 'tanggal_masuk' => '2025-08-15', 'tanggal_kembali' => '2025-08-30', 'status' => 'Belum Diambil', 'created_at' => now(), 'updated_at' => now()],
    ['jenis_berkas' => 'Satya Lencana', 'alasan' => 'Pencatatan masa bakti', 'tanggal_masuk' => '2025-08-18', 'tanggal_kembali' => '2025-09-02', 'status' => 'Sudah Dikembalikan', 'created_at' => now(), 'updated_at' => now()],
    ['jenis_berkas' => 'Penilaian Prestasi Kerja (SKP)', 'alasan' => 'Penilaian kinerja akhir', 'tanggal_masuk' => '2025-08-20', 'tanggal_kembali' => '2025-09-04', 'status' => 'Belum Dikembalikan', 'created_at' => now(), 'updated_at' => now()],
    ['jenis_berkas' => 'Ijazah', 'alasan' => 'Pendaftaran pelatihan', 'tanggal_masuk' => '2025-08-22', 'tanggal_kembali' => '2025-09-06', 'status' => 'Sudah Diambil', 'created_at' => now(), 'updated_at' => now()],
    ['jenis_berkas' => 'SK Pangkat', 'alasan' => 'Koreksi data pangkat', 'tanggal_masuk' => '2025-08-25', 'tanggal_kembali' => '2025-09-09', 'status' => 'Belum Diambil', 'created_at' => now(), 'updated_at' => now()],
    ['jenis_berkas' => 'SK CPNS', 'alasan' => 'Penyempurnaan data CPNS', 'tanggal_masuk' => '2025-08-28', 'tanggal_kembali' => '2025-09-12', 'status' => 'Sudah Dikembalikan', 'created_at' => now(), 'updated_at' => now()],
    ['jenis_berkas' => 'SK Jabatan', 'alasan' => 'Penyesuaian tugas', 'tanggal_masuk' => '2025-08-30', 'tanggal_kembali' => '2025-09-14', 'status' => 'Belum Dikembalikan', 'created_at' => now(), 'updated_at' => now()],
    ['jenis_berkas' => 'SK Mutasi Unit', 'alasan' => 'Penugasan lintas sektor', 'tanggal_masuk' => '2025-09-02', 'tanggal_kembali' => '2025-09-17', 'status' => 'Sudah Diambil', 'created_at' => now(), 'updated_at' => now()],
    ['jenis_berkas' => 'SK Pemberhentian', 'alasan' => 'Pemberhentian karena reorganisasi', 'tanggal_masuk' => '2025-09-05', 'tanggal_kembali' => '2025-09-20', 'status' => 'Belum Diambil', 'created_at' => now(), 'updated_at' => now()],
    ['jenis_berkas' => 'Sertifikasi', 'alasan' => 'Validasi kompetensi', 'tanggal_masuk' => '2025-09-08', 'tanggal_kembali' => '2025-09-23', 'status' => 'Sudah Dikembalikan', 'created_at' => now(), 'updated_at' => now()],
    ['jenis_berkas' => 'Satya Lencana', 'alasan' => 'Pembaruan data masa kerja', 'tanggal_masuk' => '2025-09-10', 'tanggal_kembali' => '2025-09-25', 'status' => 'Belum Dikembalikan', 'created_at' => now(), 'updated_at' => now()],
    ['jenis_berkas' => 'Penilaian Prestasi Kerja (SKP)', 'alasan' => 'Evaluasi akhir periode', 'tanggal_masuk' => '2025-09-12', 'tanggal_kembali' => '2025-09-27', 'status' => 'Sudah Diambil', 'created_at' => now(), 'updated_at' => now()],
    ['jenis_berkas' => 'Ijazah', 'alasan' => 'Administrasi seleksi', 'tanggal_masuk' => '2025-09-15', 'tanggal_kembali' => '2025-09-30', 'status' => 'Belum Diambil', 'created_at' => now(), 'updated_at' => now()],
    ['jenis_berkas' => 'SK Pangkat', 'alasan' => 'Pembaruan riwayat pangkat', 'tanggal_masuk' => '2025-09-18', 'tanggal_kembali' => '2025-10-03', 'status' => 'Sudah Dikembalikan', 'created_at' => now(), 'updated_at' => now()],
    ['jenis_berkas' => 'SK CPNS', 'alasan' => 'Final audit data CPNS', 'tanggal_masuk' => '2025-09-20', 'tanggal_kembali' => '2025-10-05', 'status' => 'Belum Dikembalikan', 'created_at' => now(), 'updated_at' => now()],
    ['jenis_berkas' => 'SK Jabatan', 'alasan' => 'Peninjauan ulang jabatan', 'tanggal_masuk' => '2025-09-22', 'tanggal_kembali' => '2025-10-07', 'status' => 'Sudah Diambil', 'created_at' => now(), 'updated_at' => now()],
    ['jenis_berkas' => 'SK Mutasi Unit', 'alasan' => 'Penugasan strategis', 'tanggal_masuk' => '2025-09-25', 'tanggal_kembali' => '2025-10-10', 'status' => 'Belum Diambil', 'created_at' => now(), 'updated_at' => now()],
    ['jenis_berkas' => 'SK Pemberhentian', 'alasan' => 'Pemberhentian akhir masa tugas', 'tanggal_masuk' => '2025-09-28', 'tanggal_kembali' => '2025-10-13', 'status' => 'Sudah Dikembalikan', 'created_at' => now(), 'updated_at' => now()],
    ['jenis_berkas' => 'Sertifikasi', 'alasan' => 'Pembaruan sertifikasi akhir', 'tanggal_masuk' => '2025-09-30', 'tanggal_kembali' => '2025-10-15', 'status' => 'Belum Dikembalikan', 'created_at' => now(), 'updated_at' => now()],
    ['jenis_berkas' => 'Satya Lencana', 'alasan' => 'Penyelesaian data penghargaan', 'tanggal_masuk' => '2025-10-02', 'tanggal_kembali' => '2025-10-17', 'status' => 'Sudah Diambil', 'created_at' => now(), 'updated_at' => now()],
    ['jenis_berkas' => 'Penilaian Prestasi Kerja (SKP)', 'alasan' => 'Penilaian akhir kinerja', 'tanggal_masuk' => '2025-10-05', 'tanggal_kembali' => '2025-10-20', 'status' => 'Belum Diambil', 'created_at' => now(), 'updated_at' => now()],
]);
    }

    /**
     * Truncate all tables to start fresh
     */
    protected function truncateTables(): void
    {
        $tables = [
            'users',
            'password_reset_tokens',
            'sessions',
            'cache',
            'cache_locks',
            'jobs',
            'job_batches',
            'failed_jobs',
            'cpnss',
            'ijazahs',
            'jabatans',
            'mutasis',
            'pangkats',
            'pemberhentians',
            'transaksis'
        ];

        foreach ($tables as $table) {
            DB::table($table)->truncate();
        }
    }
}