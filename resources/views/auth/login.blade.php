<!DOCTYPE html>
<html lang="en">
{{-- Include ส่วน Head จากไฟล์ themes/head.blade.php --}}
@include('themes.head')

<body class="hold-transition login-page">
<div class="login-box">
  <div class="login-logo">
    <a href="#"><b>Admin</b></a>
  </div>
  <!-- /.login-logo -->
  <div class="card">
    <div class="card-body login-card-body">
      <p class="login-box-msg">กรุณาเข้าสู่ระบบ</p>

      <form action="{{ route('login') }}" method="post">
        @csrf
        <div class="input-group mb-3">
            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" placeholder="Email" value="{{ old('email') }}" required autofocus>
            <div class="input-group-append">
                <div class="input-group-text">
                    <span class="fas fa-envelope"></span>
                </div>
            </div>
        </div>

        {{-- แสดงข้อความ Error ใต้ input field โดยตรง --}}
        @error('email')
            <span class="text-danger d-block" style="margin-top: -10px; margin-bottom: 10px;">{{ $message }}</span>
        @enderror

        <div class="input-group mb-3">
            <input type="password" name="password" class="form-control" placeholder="Password" required>
            <div class="input-group-append">
                <div class="input-group-text">
                    <span class="fas fa-lock"></span>
                </div>
            </div>
        </div>
        <div class="row">
      
          <div class="col-8">
            <button type="submit" class="btn btn-primary btn-block">เข้าสู่ระบบ</button>
          </div>
          <!-- /.col -->
        </div>
      </form>

    </div>
    <!-- /.login-card-body -->
  </div>
</div>
<!-- /.login-box -->

{{-- Include ส่วน Script จากไฟล์ themes/script.blade.php --}}
@include('themes.script')

</body>
</html>
