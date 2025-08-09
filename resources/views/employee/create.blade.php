@extends('themes.index')

@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>เพิ่มข้อมูลพนักงาน</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('employees.index') }}">จัดการพนักงาน</a></li>
                    <li class="breadcrumb-item active">เพิ่มข้อมูลพนักงาน</li>
                </ol>
            </div>
        </div>
    </div>
</section>

<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">กรอกข้อมูลพนักงานใหม่</h3>
                    </div>
                    <form action="{{ route('employees.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="card-body">
                            {{-- แสดงข้อความแจ้งเตือนเมื่อสำเร็จ หรือ เกิดข้อผิดพลาด --}}
                            @if(session('success'))
                                <div class="alert alert-success alert-dismissible">
                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                    <h5><i class="icon fas fa-check"></i> สำเร็จ!</h5>
                                    {{ session('success') }}
                                </div>
                            @endif
                             @if(session('error'))
                                <div class="alert alert-danger alert-dismissible">
                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                    <h5><i class="icon fas fa-ban"></i> เกิดข้อผิดพลาด!</h5>
                                    {{ session('error') }}
                                </div>
                            @endif

                             {{-- แสดงข้อผิดพลาดจาก Validation --}}
                             @if ($errors->any())
                                <div class="alert alert-danger">
                                    <h5 class="mb-2"><i class="icon fas fa-ban"></i> กรุณาตรวจสอบข้อมูล:</h5>
                                    <ul class="mb-0">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="firstname">ชื่อจริง</label>
                                        <input type="text" class="form-control" name="firstname" placeholder="กรอกชื่อจริง" value="{{ old('firstname') }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="lastname">นามสกุล</label>
                                        <input type="text" class="form-control" name="lastname" placeholder="กรอกนามสกุล" value="{{ old('lastname') }}">
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="email">อีเมล (สำหรับเข้าระบบ)</label>
                                <input type="email" class="form-control" name="email" placeholder="กรอกอีเมล" value="{{ old('email') }}">
                            </div>
                            
                            <div class="form-group">
                                <label for="role">กำหนดสิทธิ์ (Role)</label>
                                <select class="form-control" id="role" name="role">
                                    <option value="employee" {{ old('role') == 'employee' ? 'selected' : '' }}>Employee</option>
                                    <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                                </select>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="password">รหัสผ่าน</label>
                                        <input type="password" class="form-control" name="password" placeholder="กรอกรหัสผ่าน">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="password_confirmation">ยืนยันรหัสผ่าน</label>
                                        <input type="password" class="form-control" name="password_confirmation" placeholder="กรอกรหัสผ่านอีกครั้ง">
                                    </div>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label for="phone">เบอร์โทรศัพท์</label>
                                <input type="text" class="form-control" id="phone" name="phone" placeholder="กรอกเบอร์โทรศัพท์" value="{{ old('phone') }}">
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="department">แผนก</label>
                                        <input type="text" class="form-control" id="department" name="department" placeholder="กรอกแผนก" value="{{ old('department') }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="position">ตำแหน่ง</label>
                                        <input type="text" class="form-control" id="position" name="position" placeholder="กรอกตำแหน่ง" value="{{ old('position') }}">
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="hire_date">วันที่เริ่มงาน</label>
                                <input type="date" class="form-control" id="hire_date" name="hire_date" value="{{ old('hire_date') }}">
                            </div>

                            <div class="form-group">
                                <label for="profile_image">รูปโปรไฟล์</label>
                                <div class="input-group">
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" id="profile_image" name="profile_image">
                                        <label class="custom-file-label" for="profile_image">เลือกไฟล์</label>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">บันทึกข้อมูล</button>
                            <a href="{{ route('employees.index') }}" class="btn btn-secondary">ยกเลิก</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const fileInput = document.querySelector('.custom-file-input');
        if (fileInput) {
            fileInput.addEventListener('change', function (e) {
                const fileName = e.target.files[0] ? e.target.files[0].name : 'เลือกไฟล์';
                const nextSibling = e.target.nextElementSibling;
                if (nextSibling) {
                    nextSibling.innerText = fileName;
                }
            });
        }
    });
</script>
@endpush
