<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employee;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\File; // Import File facade for file operations
use Illuminate\Validation\Rule;

class EmployeeController extends Controller
{
    // ... (index, create, store, edit, update methods) ...
    public function index()
    {
        $employees = Employee::with('user')->get();
        return view('employee.index', compact('employees'));
    }

    public function create()
    {
        return view('employee.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'firstname' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|in:employee,admin',
            'phone' => 'nullable|string|max:20',
            'department' => 'required|string|max:255',
            'position' => 'required|string|max:255',
            'hire_date' => 'required|date',
            'profile_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        try {
            $user = User::create([
                'email' => $request->email,
                'password' => $request->password,
                'role' => $request->role,
            ]);

            $imageName = null;
            if ($request->hasFile('profile_image')) {
                $imageName = time().'.'.$request->profile_image->extension();
                $request->profile_image->move(public_path('images/profiles'), $imageName);
            }

            Employee::create([
                'user_id' => $user->id,
                'employee_code' => 'EMP'.str_pad($user->id, 5, '0', STR_PAD_LEFT),
                'firstname' => $request->firstname,
                'lastname' => $request->lastname,
                'phone' => $request->phone,
                'department' => $request->department,
                'position' => $request->position,
                'hire_date' => $request->hire_date,
                'status' => 'active',
                'profile_image' => $imageName,
            ]);

        } catch (\Exception $e) {
            Log::error('Error creating employee: ' . $e->getMessage());
            return back()->with('error', 'เกิดข้อผิดพลาดในการบันทึกข้อมูล')->withInput();
        }

        return redirect()->route('employees.index')->with('success', 'เพิ่มข้อมูลพนักงานเรียบร้อยแล้ว!');
    }
    
    public function edit(Employee $employee)
    {
        return view('employee.edit', compact('employee'));
    }

    public function update(Request $request, Employee $employee)
    {
        $request->validate([
            'firstname' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'email' => ['required', 'email', Rule::unique('users')->ignore($employee->user_id)],
            'phone' => 'nullable|string|max:20',
            'department' => 'required|string|max:255',
            'position' => 'required|string|max:255',
            'hire_date' => 'required|date',
            'profile_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        try {
            $employee->user->update([
                'email' => $request->email,
            ]);

            $imageName = $employee->profile_image;
            if ($request->hasFile('profile_image')) {
                // ลบรูปเก่า (ถ้ามี)
                if ($imageName && File::exists(public_path('images/profiles/' . $imageName))) {
                    File::delete(public_path('images/profiles/' . $imageName));
                }
                $imageName = time().'.'.$request->profile_image->extension();
                $request->profile_image->move(public_path('images/profiles'), $imageName);
            }

            $employee->update([
                'firstname' => $request->firstname,
                'lastname' => $request->lastname,
                'phone' => $request->phone,
                'department' => $request->department,
                'position' => $request->position,
                'hire_date' => $request->hire_date,
                'profile_image' => $imageName,
                'status' => $request->status ?? $employee->status,
            ]);

        } catch (\Exception $e) {
            Log::error('Error updating employee: ' . $e->getMessage());
            return back()->with('error', 'เกิดข้อผิดพลาดในการอัปเดตข้อมูล')->withInput();
        }

        return redirect()->route('employees.index')->with('success', 'อัปเดตข้อมูลพนักงานเรียบร้อยแล้ว!');
    }


    /**
     * ===================================================
     * เพิ่มฟังก์ชันนี้: ลบข้อมูลพนักงาน
     * ===================================================
     */
    public function destroy(Employee $employee)
    {
        try {
            // 1. ลบรูปโปรไฟล์ออกจาก server (ถ้ามี)
            if ($employee->profile_image && File::exists(public_path('images/profiles/' . $employee->profile_image))) {
                File::delete(public_path('images/profiles/' . $employee->profile_image));
            }

            // 2. ลบข้อมูล User (ข้อมูล Employee จะถูกลบตามไปด้วยเพราะ onDelete('cascade'))
            $employee->user()->delete();

        } catch (\Exception $e) {
            Log::error('Error deleting employee: ' . $e->getMessage());
            return back()->with('error', 'เกิดข้อผิดพลาดในการลบข้อมูล');
        }

        // 3. กลับไปหน้ารายการ พร้อมข้อความ success
        return redirect()->route('employees.index')->with('success', 'ลบข้อมูลพนักงานเรียบร้อยแล้ว!');
    }
}
