<?php

namespace Database\Seeders;

use App\Models\Kecamatan;
use App\Models\Sektor;
use App\Models\User;
use Database\Seeders\LaporanSeeder;
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

        $this->call([
            SektorSeeder::class,
            KecamatanSeeder::class,
            LaporanSeeder::class
        ]);
    }
}
