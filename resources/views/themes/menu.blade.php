<aside class="main-sidebar sidebar-dark-primary elevation-4">


    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        {{-- ใช้ @auth เพื่อตรวจสอบว่ามีการล็อกอินอยู่หรือไม่ --}}
        @auth
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                {{-- ตรวจสอบว่าพนักงานมีรูปโปรไฟล์หรือไม่ --}}
                @if(Auth::user()->employee && Auth::user()->employee->profile_image)
                    <img src="{{ asset('images/profiles/' . Auth::user()->employee->profile_image) }}" class="img-circle elevation-2" alt="User Image">
                @else
                    {{-- หากไม่มี ให้ใช้รูปภาพเริ่มต้น --}}
                    <img src="{{ asset('dist/img/user2-160x160.jpg')}}" class="img-circle elevation-2" alt="User Image">
                @endif
            </div>
            <div class="info">
                {{-- ตรวจสอบว่ามีข้อมูลพนักงานหรือไม่ ถ้ามีให้แสดงชื่อ-สกุล, ถ้าไม่มีให้แสดงอีเมล --}}
                <a href="#" class="d-block">
                    {{ Auth::user()->employee ? Auth::user()->employee->firstname . ' ' . Auth::user()->employee->lastname : Auth::user()->email }}
                </a>
            </div>
        </div>
        @endauth

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item">
                    <a href="{{ url('/dashboard') }}" class="nav-link">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>Dashboard</p>
                    </a>
                </li>
                
                {{-- จัดการข้อมูลพนักงาน --}}
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-users"></i>
                        <p>
                            จัดการพนักงาน
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('employees.index') }}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>ข้อมูลพนักงานทั้งหมด</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('employees.create') }}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>เพิ่มพนักงานใหม่</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-th"></i>
                        <p>
                            Widgets
                            <span class="right badge badge-danger">New</span>
                        </p>
                    </a>
                </li>
                
                <li class="nav-header">ออกจากระบบ</li>
                <li class="nav-item">
                    <a href="{{ route('logout') }}" class="nav-link" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="nav-icon fas fa-sign-out-alt"></i>
                        <p>Logout</p>
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </li>
                       
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
