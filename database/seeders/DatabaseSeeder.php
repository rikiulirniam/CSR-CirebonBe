<?php

namespace Database\Seeders;

use App\Models\Kecamatan;
use App\Models\Sektor;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        // Default Admin
        User::create([
            'name' => "Riki",
            'email' => 'defaultadmin@gmail.com',
            'password' => '123qwe',
            'role' => true
        ]);

        // Kecamatan
        Kecamatan::insert([
            ['id' => 1, 'nama' => 'Arjawinangun'],
            ['id' => 2, 'nama' => 'Astanajapura'],
            ['id' => 3, 'nama' => 'Babakan'],
            ['id' => 4, 'nama' => 'Beber'],
            ['id' => 5, 'nama' => 'Ciledug'],
            ['id' => 6, 'nama' => 'Ciwaringin'],
            ['id' => 7, 'nama' => 'Depok'],
            ['id' => 8, 'nama' => 'Dukupuntang'],
            ['id' => 9, 'nama' => 'Gebang'],
            ['id' => 10, 'nama' => 'Gegesik'],
            ['id' => 11, 'nama' => 'Gempol'],
            ['id' => 12, 'nama' => 'Greged'],
            ['id' => 13, 'nama' => 'Gunung Jati'],
            ['id' => 14, 'nama' => 'Jamblang'],
            ['id' => 15, 'nama' => 'Kaliwedi'],
            ['id' => 16, 'nama' => 'Kapetakan'],
            ['id' => 17, 'nama' => 'Karangsembung'],
            ['id' => 18, 'nama' => 'Karangwareng'],
            ['id' => 19, 'nama' => 'Kedawung'],
            ['id' => 20, 'nama' => 'Klangenan'],
            ['id' => 21, 'nama' => 'Lemahabang'],
            ['id' => 22, 'nama' => 'Losari'],
            ['id' => 23, 'nama' => 'Mundu'],
            ['id' => 24, 'nama' => 'Pabedilan'],
            ['id' => 25, 'nama' => 'Pabuaran'],
            ['id' => 26, 'nama' => 'Palimanan'],
            ['id' => 27, 'nama' => 'Panguragan'],
            ['id' => 28, 'nama' => 'Pasaleman'],
            ['id' => 29, 'nama' => 'Plered'],
            ['id' => 30, 'nama' => 'Plumbon'],
            ['id' => 31, 'nama' => 'Sedong'],
            ['id' => 32, 'nama' => 'Sumber'],
            ['id' => 33, 'nama' => 'Suranenggala'],
            ['id' => 34, 'nama' => 'Susukan'],
            ['id' => 35, 'nama' => 'Susukanlebak'],
            ['id' => 36, 'nama' => 'Talun'],
            ['id' => 37, 'nama' => 'Tengah Tani'],
            ['id' => 38, 'nama' => 'Waled'],
            ['id' => 39, 'nama' => 'Weru'],
            ['id' => 40, 'nama' => 'Cirebon Utara'],
        ]);

        // Default Sektor
        Sektor::insert([
            [
                'image' => '/images/sektor/sosial.png',
                'judul' => 'Sosial',
                'deskripsi' => "Lorem ipsum, dolor sit amet consectetur adipisicing elit. Explicabo soluta voluptatem et, quia nobis nulla quasi in, vero animi ex, suscipit ad! Atque dolorum quod mollitia amet illo quibusdam voluptatibus."
            ],
            [
                'image' => '/images/sektor/lingkungan.png',
                'judul' => 'Lingkungan',
                'deskripsi' => "Lorem ipsum, dolor sit amet consectetur adipisicing elit. Explicabo soluta voluptatem et, quia nobis nulla quasi in, vero animi ex, suscipit ad! Atque dolorum quod mollitia amet illo quibusdam voluptatibus."
            ],
            [
                'image' => '/images/sektor/kesehatan.png',
                'judul' => 'Kesehatan',
                'deskripsi' => "Lorem ipsum, dolor sit amet consectetur adipisicing elit. Explicabo soluta voluptatem et, quia nobis nulla quasi in, vero animi ex, suscipit ad! Atque dolorum quod mollitia amet illo quibusdam voluptatibus."
            ]

        ]);
    }
}
