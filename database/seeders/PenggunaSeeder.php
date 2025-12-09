<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Pengguna;
use Illuminate\Support\Facades\Hash;

class PenggunaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Akun Karyawan
        Pengguna::create([
            'email' => 'AdminVick@gmail.com',
            'password' => Hash::make('Adminkyky'),
            'role' => 'karyawan',
        ]);

        // Akun Kasir
        Pengguna::create([
            'email' => 'ChasierVick@gmail.com',
            'password' => Hash::make('Chashkyky'),
            'role' => 'kasir',
        ]);
    }
}
