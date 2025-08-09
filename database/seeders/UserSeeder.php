<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User; // Import User model
use Illuminate\Support\Facades\Hash; // Import Hash

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // สร้างผู้ใช้ใหม่
        User::create([
            'email' => 'admin@example.com', // อีเมลสำหรับล็อกอิน
            'password' => Hash::make('74123'), // รหัสผ่าน (เข้ารหัสแล้ว)
            'role' => 'admin', // กำหนดสิทธิ์เป็น admin
        ]);
    }
}