<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class JadwalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();
        
        // Misalnya, kita punya mahasiswa dengan ID 1 hingga 10
        foreach (range(1, 2) as $index) {
            DB::table('jadwal')->insert([
                'mahasiswa_id' => $faker->numberBetween(1, 2), // ID mahasiswa antara 1 sampai 10
                'hari' => $faker->randomElement(['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat']), // Pilih hari acak
                'waktu_mulai' => $faker->time('H:i:s'), // Waktu mulai
                'waktu_selesai' => $faker->time('H:i:s'), // Waktu selesai
                'mata_kuliah' => $faker->words(3, true), // Nama mata kuliah acak
                'ruang' => 'Ruang ' . $faker->randomDigitNotNull(), // Ruangan acak
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
