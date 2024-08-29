<?php

namespace Database\Seeders;

use App\Models\Program;
use App\Models\Sektor;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class SektorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $sektors = [
            [
                'name' => 'Sosial',
                'deskripsi' => "Program ini bertujuan untuk meningkatkan kesejahteraan sosial masyarakat, khususnya bagi mereka yang membutuhkan bantuan dan dukungan.",
                'image' => '/images/sektor/sosial.png',
                'programs' => [
                    ['nama' => 'Rehabilitasi Sosial', 'deskripsi' => "Menyediakan layanan rehabilitasi bagi penyandang masalah kesejahteraan sosial agar mereka dapat kembali berfungsi secara sosial di masyarakat."],
                    ['nama' => 'Jaminan Sosial', 'deskripsi' => "Memberikan perlindungan sosial bagi masyarakat yang rentan melalui berbagai program jaminan sosial seperti BPJS Kesehatan dan BPJS Ketenagakerjaan."],
                    ['nama' => 'Pemberdayaan Sosial', 'deskripsi' => "Mengembangkan potensi dan kemampuan individu atau kelompok masyarakat agar dapat hidup lebih mandiri dan sejahtera."],
                    ['nama' => 'Perlindungan Sosial terhadap PMKS', 'deskripsi' => "Memberikan bantuan dan perlindungan khusus bagi Penyandang Masalah Kesejahteraan Sosial (PMKS), termasuk anak jalanan, orang tua terlantar, dan korban bencana."]
                ]
            ],
            [
                'name' => 'Lingkungan',
                'deskripsi' => "Program lingkungan bertujuan untuk melestarikan alam dan mengurangi dampak negatif kegiatan manusia terhadap lingkungan.",
                'image' => '/images/sektor/lingkungan.png',
                'programs' => [
                    ['nama' => 'Penanaman Pohon', 'deskripsi' => "Mengadakan kegiatan penanaman pohon di berbagai lokasi untuk meningkatkan tutupan hijau dan mengurangi emisi karbon."],
                    ['nama' => 'Pengelolaan Sampah', 'deskripsi' => "Mengimplementasikan sistem pengelolaan sampah berbasis 3R (Reduce, Reuse, Recycle) untuk mengurangi jumlah sampah yang berakhir di tempat pembuangan akhir."],
                    ['nama' => 'Pelestarian Ekosistem', 'deskripsi' => "Melakukan upaya pelestarian terhadap ekosistem alami, termasuk hutan, pantai, dan sungai."],
                    ['nama' => 'Kampanye Lingkungan', 'deskripsi' => "Meningkatkan kesadaran masyarakat tentang pentingnya menjaga lingkungan melalui kampanye dan edukasi."]
                ]
            ],
            [
                'name' => 'Kesehatan',
                'deskripsi' => "Program kesehatan fokus pada peningkatan kualitas layanan kesehatan dan pencegahan penyakit di masyarakat.",
                'image' => '/images/sektor/kesehatan.png',
                'programs' => [
                    ['nama' => 'Puskesmas Keliling', 'deskripsi' => "Layanan kesehatan mobile yang menjangkau masyarakat di daerah terpencil untuk memberikan pemeriksaan kesehatan gratis."],
                    ['nama' => 'Posyandu', 'deskripsi' => "Program kesehatan terpadu yang menyasar ibu hamil, balita, dan lansia untuk memantau kesehatan dan gizi mereka."],
                    ['nama' => 'Vaksinasi Massal', 'deskripsi' => "Mengadakan program vaksinasi massal untuk mencegah penyebaran penyakit menular seperti COVID-19 dan DBD."],
                    ['nama' => 'Kampanye Hidup Sehat', 'deskripsi' => "Kampanye yang mengedukasi masyarakat tentang pentingnya pola hidup sehat dan pencegahan penyakit melalui olahraga dan nutrisi."]
                ]
            ],
            [
                'name' => 'Pendidikan',
                'deskripsi' => "Program pendidikan dirancang untuk meningkatkan kualitas pendidikan dan memberikan akses belajar bagi seluruh lapisan masyarakat.",
                'image' => '/images/sektor/pendidikan.png',
                'programs' => [
                    ['nama' => 'Beasiswa Pendidikan', 'deskripsi' => "Memberikan beasiswa kepada siswa berprestasi dan kurang mampu untuk melanjutkan pendidikan ke jenjang yang lebih tinggi."],
                    ['nama' => 'Peningkatan Sarana dan Prasarana Sekolah', 'deskripsi' => "Pembangunan dan renovasi fasilitas pendidikan untuk menciptakan lingkungan belajar yang lebih baik dan aman."],
                    ['nama' => 'Program Literasi', 'deskripsi' => "Mengadakan pelatihan dan kegiatan yang bertujuan meningkatkan kemampuan membaca dan menulis anak-anak dan orang dewasa."],
                    ['nama' => 'Pendidikan Karakter', 'deskripsi' => "Menyelenggarakan program pendidikan yang menekankan pada pengembangan karakter dan nilai-nilai moral siswa."]
                ]
            ],
            [
                'name' => 'Infrastruktur dan Sanitasi Lingkungan',
                'deskripsi' => "Program ini bertujuan untuk meningkatkan kualitas infrastruktur dan sanitasi di lingkungan sekitar, sehingga menciptakan lingkungan yang lebih sehat dan nyaman.",
                'image' => '/images/sektor/infrastruktur.png',
                'programs' => [
                    ['nama' => 'Pembangunan Jalan dan Jembatan', 'deskripsi' => "Pembangunan dan perbaikan jalan serta jembatan untuk memperlancar akses transportasi di daerah terpencil."],
                    ['nama' => 'Penyediaan Air Bersih', 'deskripsi' => "Menyediakan akses air bersih dan layak konsumsi bagi masyarakat yang tinggal di daerah yang kesulitan mendapatkan air bersih."],
                    ['nama' => 'Pengelolaan Sanitasi', 'deskripsi' => "Pembangunan fasilitas sanitasi yang layak seperti toilet umum dan tempat pembuangan limbah untuk meningkatkan kualitas kebersihan lingkungan."],
                    ['nama' => 'Pembangunan Sarana Drainase', 'deskripsi' => "Pembangunan dan perbaikan saluran drainase untuk mencegah banjir dan genangan air yang dapat mengganggu kesehatan masyarakat."]
                ]
            ],
            [
                'name' => 'Sarana dan Prasarana Keagamaan',
                'deskripsi' => "Program ini berfokus pada pembangunan dan perbaikan sarana serta prasarana keagamaan untuk mendukung kegiatan ibadah dan keagamaan masyarakat.",
                'image' => '/images/sektor/keagamaan.png',
                'programs' => [
                    ['nama' => 'Renovasi Masjid dan Mushola', 'deskripsi' => "Melakukan renovasi dan perbaikan masjid dan mushola yang membutuhkan perbaikan untuk menciptakan tempat ibadah yang layak dan nyaman."],
                    ['nama' => 'Penyediaan Alat Ibadah', 'deskripsi' => "Menyediakan dan mendistribusikan alat-alat ibadah seperti Al-Quran, sajadah, dan perlengkapan ibadah lainnya kepada masjid dan mushola."],
                    ['nama' => 'Kegiatan Keagamaan dan Pengajian', 'deskripsi' => "Menyelenggarakan berbagai kegiatan keagamaan seperti pengajian, tabligh akbar, dan perayaan hari besar agama untuk mempererat tali silaturahmi dan memperkuat iman masyarakat."],
                    ['nama' => 'Pendidikan Keagamaan', 'deskripsi' => "Menyediakan program pendidikan keagamaan seperti TPA (Taman Pendidikan Al-Quran) dan madrasah untuk anak-anak dan remaja."]
                ]
            ],
        ];

        foreach ($sektors as $sektor) {
            $createdSektor = Sektor::create([
                'name' => $sektor['name'],
                'deskripsi' => $sektor['deskripsi'],
                'image' => $sektor['image']
            ]);

            foreach ($sektor['programs'] as $program) {
                Program::create([
                    'sektor_id' => $createdSektor->id,
                    'nama' => $program['nama'],
                    'deskripsi' => $program['deskripsi'],
                ]);
            }

            // Simpan gambar di storage
            $imagePath = storage_path('app/public' . $sektor['image']);
            if (!file_exists($imagePath)) {
                Storage::disk('public')->put($sektor['image'], file_get_contents($imagePath));
            }
        }
    }
}
