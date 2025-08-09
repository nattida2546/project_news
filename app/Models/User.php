<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\Hash; // **1. Import Hash**

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'email',
        'password',
        'role',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * ความสัมพันธ์กับพนักงาน
     */
    public function employee()
    {
        return $this->hasOne(Employee::class);
    }

    /**
     * ===================================================
     * 2. เพิ่มส่วนนี้: เข้ารหัสรหัสผ่านโดยอัตโนมัติ (Mutator)
     * ===================================================
     * ฟังก์ชันนี้จะทำงานทุกครั้งที่มีการตั้งค่า password ให้กับ User Model
     * ทำให้รหัสผ่านถูกเข้ารหัสก่อนบันทึกลงฐานข้อมูลเสมอ
     */
    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = Hash::make($value);
    }
}
