<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // เพิ่มบรรทัดนี้เพื่อเรียกใช้ UserSeeder
        $this->call([
            UserSeeder::class,
        ]);
    }
}