<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class MahasiswaSeeder extends Seeder
{
    public function run()
    {
        // Menggunakan Faker untuk generate data dummy
        $faker = Faker::create();

        // Menambahkan data mahasiswa dummy ke dalam tabel tb_mahasiswa
        DB::table('tb_mahasiswa')->insert([
            [
                'nim' => '123456789',
                'nama' => 'John Doe',
                'alamat' => 'Jl. Merdeka No. 123, Jakarta',
                'tempat' => 'Jakarta',
                'tgl_lahir' => $faker->date('Y-m-d'),
                'email' => 'john.doe@example.com',
                'status_pembayaran' => 'Lunas',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nim' => '987654321',
                'nama' => 'Jane Smith',
                'alamat' => 'Jl. Kemerdekaan No. 456, Surabaya',
                'tempat' => 'Surabaya',
                'tgl_lahir' => $faker->date('Y-m-d'),
                'email' => 'jane.smith@example.com',
                'status_pembayaran' => 'Belum Lunas',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // Anda bisa menambahkan lebih banyak data dummy jika diperlukan...
        ]);
    }
}
