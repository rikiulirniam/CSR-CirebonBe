<?php

namespace Database\Seeders;

use App\Models\Kegiatan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class KegiatanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $kegiatans = [
            [
                'thumbnail' => '/images/kegiatan/kegiatan1.jpg',
                'judul' => 'Penanaman 1000 Pohon',
                'tags' => 'Lingkungan, Penghijauan',
                'deskripsi' => 'Program penghijauan di sekitar wilayah perkotaan untuk meningkatkan kualitas udara.',
                'status' => true,
            ],
            [
                'thumbnail' => '/images/kegiatan/kegiatan2.jpg',
                'judul' => 'Donasi Buku untuk Sekolah',
                'tags' => 'Pendidikan, Donasi',
                'deskripsi' => 'Donasi buku pelajaran dan alat tulis untuk sekolah-sekolah di pedesaan.',
                'status' => true,
            ],
            [
                'thumbnail' => '/images/kegiatan/kegiatan3.jpg',
                'judul' => 'Kampanye Anti Sampah Plastik',
                'tags' => 'Lingkungan, Sosialisasi',
                'deskripsi' => 'Sosialisasi kepada masyarakat untuk mengurangi penggunaan sampah plastik.',
                'status' => true,
            ],
            [
                'thumbnail' => '/images/kegiatan/kegiatan4.jpg',
                'judul' => 'Pelatihan Keterampilan Kerja',
                'tags' => 'Ekonomi, Pelatihan',
                'deskripsi' => 'Pelatihan bagi masyarakat kurang mampu untuk meningkatkan keterampilan kerja.',
                'status' => true,
            ],
            [
                'thumbnail' => '/images/kegiatan/kegiatan5.jpg',
                'judul' => 'Pembangunan Sarana Air Bersih',
                'tags' => 'Kesehatan, Infrastruktur',
                'deskripsi' => 'Pembangunan fasilitas air bersih di desa yang sulit terjangkau.',
                'status' => true,
            ],
            [
                'thumbnail' => '/images/kegiatan/kegiatan6.jpg',
                'judul' => 'Bantuan Bencana Alam',
                'tags' => 'Kemanusiaan, Bantuan',
                'deskripsi' => 'Distribusi bantuan untuk korban bencana alam seperti banjir dan gempa bumi.',
                'status' => true,
            ],
            [
                'thumbnail' => '/images/kegiatan/kegiatan7.jpg',
                'judul' => 'Program Vaksinasi Gratis',
                'tags' => 'Kesehatan, Sosialisasi',
                'deskripsi' => 'Program vaksinasi gratis bagi masyarakat kurang mampu di daerah terpencil.',
                'status' => true,
            ],
            [
                'thumbnail' => '/images/kegiatan/kegiatan8.jpg',
                'judul' => 'Pengadaan Pusat Daur Ulang',
                'tags' => 'Lingkungan, Daur Ulang',
                'deskripsi' => 'Pembangunan pusat daur ulang sampah untuk meningkatkan kesadaran lingkungan.',
                'status' => true,
            ],
            [
                'thumbnail' => '/images/kegiatan/kegiatan9.jpg',
                'judul' => 'Pelatihan UMKM',
                'tags' => 'Ekonomi, Pelatihan',
                'deskripsi' => 'Pelatihan untuk pelaku usaha mikro, kecil, dan menengah agar lebih berdaya saing.',
                'status' => true,
            ],
            [
                'thumbnail' => '/images/kegiatan/kegiatan10.jpg',
                'judul' => 'Kegiatan Donor Darah',
                'tags' => 'Kesehatan, Donor',
                'deskripsi' => 'Program donor darah massal untuk memenuhi kebutuhan darah di rumah sakit.',
                'status' => true,
            ],
            [
                'thumbnail' => '/images/kegiatan/kegiatan11.jpg',
                'judul' => 'Penghijauan Lahan Kritis',
                'tags' => 'Lingkungan, Penghijauan',
                'deskripsi' => 'Penanaman pohon di lahan kritis untuk mengurangi risiko longsor dan banjir.',
                'status' => true,
            ],
            [
                'thumbnail' => '/images/kegiatan/kegiatan12.jpg',
                'judul' => 'Program Beasiswa Anak Kurang Mampu',
                'tags' => 'Pendidikan, Beasiswa',
                'deskripsi' => 'Pemberian beasiswa pendidikan kepada anak-anak dari keluarga kurang mampu.',
                'status' => true,
            ],
        ];


        foreach ($kegiatans as $data) {
            Kegiatan::create($data);
        }
    }
}
