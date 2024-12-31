<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;

class PembayaranSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();

        // Ambil mahasiswa dengan ID 2 dan 3 dari tabel tb_mahasiswa
        $mahasiswa = DB::table('tb_mahasiswa')->whereIn('id', [2, 3])->get();

        foreach ($mahasiswa as $index => $data) {
            DB::table('tb_pembayaran')->insert([
                'mahasiswa_id' => $data->id, // ID mahasiswa dari tabel tb_mahasiswa
                'nim' => $data->nim, // NIM dari tabel tb_mahasiswa
                'nama' => $data->nama, // Nama mahasiswa dari tabel tb_mahasiswa
                'nominal' => $faker->randomFloat(2, 100000, 1000000), // Nominal pembayaran acak
                'metode_pembayaran' => $faker->randomElement(['Transfer', 'Cash', 'Debit']), // Metode pembayaran acak
                'status_pembayaran' => $faker->randomElement(['LUNAS', 'BELUM_LUNAS']), // Status pembayaran acak
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
