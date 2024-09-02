<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Laporan;
use App\Models\Proyek;

class LaporanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Dapatkan semua proyek yang ada
        $proyeks = Proyek::all();

        // ID Mitra yang ada, diasumsikan hanya ada satu mitra
        $mitraId = 1;

        // Status yang ingin diacak
        $statuses = ['draf', 'diterima', 'ditolak'];

        // Loop melalui setiap proyek untuk membuat beberapa laporan
        foreach ($proyeks as $proyek) {
            // Tentukan berapa banyak laporan yang ingin dibuat untuk proyek ini
            $jumlahLaporan = rand(1, 5); // Bisa membuat antara 1 sampai 5 laporan untuk setiap proyek

            for ($i = 0; $i < $jumlahLaporan; $i++) {
                Laporan::create([
                    'judul' => 'Laporan ' . ucfirst($statuses[array_rand($statuses)]) . ' untuk ' . $proyek->nama,
                    'dana_realisasi' => rand(1000000, 10000000), // Random dana realisasi
                    'tgl_realisasi' => now()->subDays(rand(1, 365)), // Random tanggal dalam 1 tahun terakhir
                    'status' => $statuses[array_rand($statuses)], // Ambil status acak dari daftar
                    'tanggapan' => rand(0, 1) ? 'Tanggapan random...' : null, // Acak apakah ada tanggapan atau tidak
                    'images' => json_encode([]), // Kosongkan atau isi dengan array gambar
                    'kecamatan_id' => $proyek->kecamatan_id,
                    'proyek_id' => $proyek->id,
                    'mitra_id' => $mitraId,
                ]);
            }
        }
    }
}
