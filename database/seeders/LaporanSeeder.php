<?php

namespace Database\Seeders;

use App\Models\Laporan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LaporanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $laporans = [
            [
                'judul' => 'Rehabilitasi Sekolah Dasar',
                'dana_realisasi' => 15000000,
                'tgl_realisasi' => '2024-08-01',
                'status' => 'diterima',
                'tanggapan' => 'Laporan diterima dan dana telah dicairkan.',
                'images' => json_encode(['/images/laporan/rehab_sd_1.png', '/images/laporan/rehab_sd_2.png']),
                'kecamatan_id' => 1,
                'proyek_id' => 1,
                'mitra_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'judul' => 'Pembangunan Jembatan Desa',
                'dana_realisasi' => 25000000,
                'tgl_realisasi' => '2024-07-15',
                'status' => 'revisi',
                'tanggapan' => 'Laporan membutuhkan revisi terkait rincian pengeluaran.',
                'images' => json_encode(['/images/laporan/jembatan_desa_1.png']),
                'kecamatan_id' => 2,
                'proyek_id' => 2,
                'mitra_id' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'judul' => 'Perbaikan Saluran Irigasi',
                'dana_realisasi' => 10000000,
                'tgl_realisasi' => '2024-06-30',
                'status' => 'ditolak',
                'tanggapan' => 'Laporan ditolak karena tidak sesuai dengan rencana awal.',
                'images' => json_encode(['/images/laporan/irigasi_1.png', '/images/laporan/irigasi_2.png']),
                'kecamatan_id' => 3,
                'proyek_id' => 3,
                'mitra_id' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'judul' => 'Pengadaan Perlengkapan Kesehatan',
                'dana_realisasi' => 5000000,
                'tgl_realisasi' => '2024-08-20',
                'status' => 'draf',
                'tanggapan' => null,
                'images' => json_encode(['/images/laporan/kesehatan_1.png']),
                'kecamatan_id' => 4,
                'proyek_id' => 4,
                'mitra_id' => 4,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        foreach ($laporans as $laporan) {
            Laporan::create($laporan);
        }
    }
}
