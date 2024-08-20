<div class="left-side-menu">
    <nav class="sidebar-wrapped px-4 py-1">
        <div class="sidebar">
            <div style="overflow: hidden" style="overflow: hidden" class="sidebar-group">
                <a class="sidebar-item{{ request()->is('/') ? ' active' : '' }}" href="{{route('home')}}">
                    <span>Trang chủ</span>
                </a>
            </div>
            <div style="overflow: hidden" class="sidebar-group">
                <h6 class="sidebar-title">Dữ liệu khuôn mặt</h6>
                <a class="sidebar-item{{ Str::startsWith(request()->url(), url('/train-face')) ? ' active' : '' }}"
                    href="{{route('trainface.index')}}">
                    <span>Thêm dữ liệu khuôn mặt</span>
                </a>
                <a class="sidebar-item{{ Str::startsWith(request()->url(), url('/recognition-unknown-list')) ? ' active' : '' }}"
                    href="{{route('recognition.index')}}">
                    Khuôn mặt chưa được nhận diện
                </a>
            </div>
            <div style="overflow: hidden" class="sidebar-group">
                <h6 class="sidebar-title">Công việc</h6>
                <a class="sidebar-item{{ Str::startsWith(request()->url(), url('/timekeeping')) ? ' active' : '' }}"
                    href="{{route('timekeeping.index')}}"> Chấm công
                </a>
                <a class="sidebar-item{{ Str::startsWith(request()->url(), url('/statistic')) ? ' active' : '' }}"
                    href="{{route('timekeeping.statistic')}}"> Thống kê
                </a>
            </div>
            <div style="overflow: hidden" class="sidebar-group">
                <h6 class="sidebar-title">Quản lý</h6>
                <a class="sidebar-item{{ Str::startsWith(request()->url(), url('/admin/department')) ? ' active' : '' }}"
                    href="{{route('admin.department.index')}}"> Phòng ban
                </a>
                <a class="sidebar-item{{ Str::startsWith(request()->url(), url('/admin/employee')) ? ' active' : '' }}"
                    href="{{route('admin.employee.index')}}"> Nhân viên
                </a>
            </div>
        </div>
    </nav>
</div>
