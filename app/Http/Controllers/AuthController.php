<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * แสดงฟอร์มล็อกอิน
     *
     * @return \Illuminate\View\View
     */
    public function showLoginForm()
    {
        // ควรตรวจสอบว่ามี view นี้อยู่จริง: resources/views/auth/login.blade.php
        return view('auth.login');
    }

    /**
     * จัดการคำขอเข้าระบบ
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function login(Request $request)
    {
        // เปลี่ยนจาก 'username' เป็น 'email' เพื่อให้ตรงกับ User Model และ error message
        $credentials = $request->validate([
            'email'    => ['required', 'email'], // ใช้ email และเพิ่ม rule 'email'
            'password' => ['required', 'string'],
        ]);

        // Auth::attempt จะใช้ credentials ที่ได้จาก validate เพื่อพยายามล็อกอิน
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

       
            return redirect()->intended('/dashboard');
        }

        // หากล็อกอินไม่สำเร็จ ให้กลับไปหน้าเดิมพร้อม error
        return back()->withErrors([
            'email' => 'อีเมล หรือ รหัสผ่านไม่ถูกต้อง', // key 'email' ตอนนี้ตรงกับ input field แล้ว
        ])->onlyInput('email'); // ส่งค่า email เดิมกลับไป แต่ไม่ส่ง password
    }

    /**
     * จัดการคำขอออกจากระบบ
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
