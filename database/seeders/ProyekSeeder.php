<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Proyek;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class ProyekSeeder extends Seeder
{
    public function run()
    {
        $sektorProgramMapping = [
            1 => range(1, 4),  // Jika sektor_id = 1, program_id antara 1-4
            2 => range(5, 8),  // Jika sektor_id = 2, program_id antara 5-8
            3 => range(9, 12), // Jika sektor_id = 3, program_id antara 9-12
            4 => range(13, 16), // Jika sektor_id = 4, program_id antara 13-16
            5 => range(17, 20), // Jika sektor_id = 5, program_id antara 17-20
            6 => range(21, 24), // Jika sektor_id = 6, program_id antara 21-24
        ];

        // Misalnya kita ingin membuat 10 proyek secara acak
        for ($i = 0; $i < 10; $i++) {
            $sektorId = rand(1, 6);
            $programId = $sektorProgramMapping[$sektorId][array_rand($sektorProgramMapping[$sektorId])];

            $imageName = "Proyek_" . Str::random(32) . '.jpg';

            // Simpan gambar dummy ke dalam storage

            Proyek::create([
                'nama' => 'Proyek Contoh ' . ($i + 1),
                'tanggal_awal' => now(),
                'tanggal_akhir' => now()->addDays(rand(1, 30)),
                'deskripsi' => 'Deskripsi untuk proyek contoh ' . ($i + 1),
                'image' => "images/proyek/kegiatan1.jpg",
                'status' => true,
                'kecamatan_id' => rand(1, 10), // Anda bisa sesuaikan ini dengan jumlah kecamatan yang ada
                'sektor_id' => $sektorId,
                'program_id' => $programId,
            ]);
        }
    }
}
