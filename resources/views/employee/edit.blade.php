@extends('themes.index')

@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>แก้ไขข้อมูลพนักงาน</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('employees.index') }}">จัดการพนักงาน</a></li>
                    <li class="breadcrumb-item active">แก้ไขข้อมูล</li>
                </ol>
            </div>
        </div>
    </div>
</section>

<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card card-warning"> {{-- เปลี่ยนสี card เป็นสีเหลือง --}}
                    <div class="card-header">
                        <h3 class="card-title">แก้ไขข้อมูล: {{ $employee->firstname }} {{ $employee->lastname }}</h3>
                    </div>
                    <!-- form start -->
                    {{-- เปลี่ยน action และ method ของฟอร์ม --}}
                    <form action="{{ route('employees.update', $employee->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT') {{-- ใช้ PUT method สำหรับการ update --}}

                        <div class="card-body">
                            @if(session('error'))
                                <div class="alert alert-danger">{{ session('error') }}</div>
                            @endif
                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            {{-- ใส่ value จาก $employee ลงในฟอร์ม --}}
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="firstname">ชื่อจริง</label>
                                        <input type="text" class="form-control" name="firstname" value="{{ old('firstname', $employee->firstname) }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="lastname">นามสกุล</label>
                                        <input type="text" class="form-control" name="lastname" value="{{ old('lastname', $employee->lastname) }}">
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="email">อีเมล (สำหรับเข้าระบบ)</label>
                                <input type="email" class="form-control" name="email" value="{{ old('email', $employee->user->email) }}">
                            </div>

                            <div class="form-group">
                                <label for="phone">เบอร์โทรศัพท์</label>
                                <input type="text" class="form-control" name="phone" value="{{ old('phone', $employee->phone) }}">
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="department">แผนก</label>
                                        <input type="text" class="form-control" name="department" value="{{ old('department', $employee->department) }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="position">ตำแหน่ง</label>
                                        <input type="text" class="form-control" name="position" value="{{ old('position', $employee->position) }}">
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="hire_date">วันที่เริ่มงาน</label>
                                <input type="date" class="form-control" name="hire_date" value="{{ old('hire_date', $employee->hire_date) }}">
                            </div>

                            <div class="form-group">
                                <label for="profile_image">รูปโปรไฟล์ (หากไม่ต้องการเปลี่ยน ให้เว้นว่างไว้)</label>
                                <div class="input-group">
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" id="profile_image" name="profile_image">
                                        <label class="custom-file-label" for="profile_image">เลือกไฟล์ใหม่</label>
                                    </div>
                                </div>
                                @if($employee->profile_image)
                                    <div class="mt-2">
                                        <img src="{{ asset('images/profiles/' . $employee->profile_image) }}" alt="Profile Image" width="100">
                                    </div>
                                @endif
                            </div>

                        </div>
                        <!-- /.card-body -->

                        <div class="card-footer">
                            <button type="submit" class="btn btn-warning">อัปเดตข้อมูล</button>
                            <a href="{{ route('employees.index') }}" class="btn btn-secondary">ยกเลิก</a>
                        </div>
                    </form>
                </div>
                <!-- /.card -->
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
                const fileName = e.target.files[0] ? e.target.files[0].name : 'เลือกไฟล์ใหม่';
                const nextSibling = e.target.nextElementSibling;
                if (nextSibling) {
                    nextSibling.innerText = fileName;
                }
            });
        }
    });
</script>
@endpush
