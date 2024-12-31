<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            [
                'name' => 'Admin One',
                'username' => 'admin1',
                'password' => Hash::make('password123'),
                'role' => 'admin',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'mahasiswa2',
                'username' => 'mahasiswa2',
                'password' => Hash::make('mahasiswa2'),
                'role' => 'mahasiswa',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'mahasiswa3',
                'username' => 'mahasiswa3',
                'password' => Hash::make('mahasiswa3'),
                'role' => 'mahasiswa',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
