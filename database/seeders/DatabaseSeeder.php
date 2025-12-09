<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Database\Seeders\PenggunaSeeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            PenggunaSeeder::class,
        ]);
    }
}
