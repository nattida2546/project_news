<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EmployeeController; // Import EmployeeController

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// --- กลุ่ม Route สำหรับผู้ที่ยังไม่ได้ Login ---
Route::middleware('guest')->group(function () {
    Route::get('login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('login', [AuthController::class, 'login']);
});


// --- กลุ่ม Route สำหรับผู้ที่ Login แล้วเท่านั้น ---
Route::middleware('auth')->group(function () {
    Route::post('logout', [AuthController::class, 'logout'])->name('logout');
    
    // หน้าหลักหลังจาก Login
    Route::get('/dashboard', function() {
        return view('themes.index'); // หรือจะใช้ Controller ก็ได้
    })->name('dashboard');

    // --- Route สำหรับจัดการข้อมูลพนักงาน ---
    Route::resource('employees', EmployeeController::class);
});

// Route หน้าแรกสุดของเว็บ
Route::get('/', function () {
    // ถ้า Login แล้ว ให้ไป dashboard แต่ถ้ายัง ให้ไปหน้า login
    return auth()->check() ? redirect()->route('dashboard') : redirect()->route('login');
});
