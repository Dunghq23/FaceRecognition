<div class="left-side-menu">
    <nav class="sidebar-wrapped">
        <div class="sidebar">
            <div class="sidebar-group">
                <div class="sidebar-content">
                    <a class="sidebar-item{{ request()->is('/') ? ' active' : '' }}" href="{{route('home')}}">
                        <span>Trang chủ</span>
                    </a>
                </div>
            </div>
            
            <div class="sidebar-group">
                <h6 class="sidebar-title">Quản trị Hệ thống</h6>
                <div class="sidebar-content">
                    <a class="sidebar-item{{ Str::startsWith(request()->url(), url('/management/users')) ? ' active' : '' }}"
                        href="{{route('management.users.index')}}">
                        <span>Quản lý người dùng</span>
                    </a>
                    <a class="sidebar-item{{ Str::startsWith(request()->url(), url('/management/roles')) ? ' active' : '' }}"
                        href="{{route('management.roles.index')}}">
                        <span>Phân quyền người dùng</span>
                    </a>
                    <a class="sidebar-item{{ Str::startsWith(request()->url(), url('/management/systemLogs')) ? ' active' : '' }}"
                        href="{{route('management.systemLogs.index')}}">
                        <span>Nhật ký thao tác hệ thống</span>
                    </a>
                </div>
            </div>
            
            <div class="sidebar-group">
                <h6 class="sidebar-title">Quản lý Tuyển dụng</h6>
                <div class="sidebar-content">
                    <a class="sidebar-item" href="#">
                        <span>Hồ sơ ứng viên</span>
                    </a>
                    <a class="sidebar-item" href="#">
                        <span>Lịch phỏng vấn</span>
                    </a>
                    <a class="sidebar-item" href="#">
                        <span>Thông báo phỏng vấn</span>
                    </a>
                </div>
            </div>
            
            <div class="sidebar-group">
                <h6 class="sidebar-title">Quản lý Hồ sơ nhân viên</h6>
                <div class="sidebar-content">
                    <a class="sidebar-item{{ Str::startsWith(request()->url(), url('/management/department')) ? ' active' : '' }}"
                        href="{{route('management.department.index')}}">
                        <span>Phòng ban</span>
                    </a>
                    <a class="sidebar-item{{ Str::startsWith(request()->url(), url('/management/employee')) ? ' active' : '' }}"
                        href="{{route('management.employee.index')}}">
                        <span>Nhân viên</span>
                    </a>
                    <a class="sidebar-item" href="#">
                        <span>Hợp đồng lao động</span>
                    </a>
                    <a class="sidebar-item" href="#">
                        <span>Hồ sơ, bằng cấp, chứng chỉ</span>
                    </a>
                    <a class="sidebar-item" href="#">
                        <span>Quá trình công tác, khen thưởng, kỷ luật</span>
                    </a>
                </div>
            </div>
            
            <div class="sidebar-group">
                <h6 class="sidebar-title">Quản lý Chấm công và Tính lương</h6>
                <div class="sidebar-content">
                    <a class="sidebar-item{{ Str::startsWith(request()->url(), url('/timekeeping')) ? ' active' : '' }}"
                        href="{{route('timekeeping.index')}}">
                        <span>Chấm công</span>
                    </a>
                    <a class="sidebar-item{{ Str::startsWith(request()->url(), url('/statistic')) ? ' active' : '' }}"
                        href="{{route('timekeeping.statistic')}}">
                        <span>Thống kê</span>
                    </a>
                </div>
            </div>
            
            <div class="sidebar-group">
                <h6 class="sidebar-title">Báo cáo và Thống kê</h6>
                <div class="sidebar-content">
                    <a class="sidebar-item" href="#">
                        <span>Báo cáo nhân sự</span>
                    </a>
                    <a class="sidebar-item" href="#">
                        <span>Báo cáo lương</span>
                    </a>
                    <a class="sidebar-item" href="#">
                        <span>Báo cáo ngày công</span>
                    </a>
                </div>
            </div>

            <div class="sidebar-group">
                <h6 class="sidebar-title">Chức năng khác</h6>
                <div class="sidebar-content">
                    <a class="sidebar-item{{ Str::startsWith(request()->url(), url('/train-face')) ? ' active' : '' }}"
                        href="{{route('trainface.index')}}">
                        <span>Thêm dữ liệu khuôn mặt</span>
                    </a>
                    <a class="sidebar-item{{ Str::startsWith(request()->url(), url('/recognition-unknown-list')) ? ' active' : '' }}"
                        href="{{route('recognition.index')}}">
                        <span>Khuôn mặt chưa được nhận diện</span>
                    </a>
                    <a class="sidebar-item" href="#">
                        <span>Quản lý truyền thông</span>
                    </a>
                    <a class="sidebar-item" href="#">
                        <span>Cổng thông tin nhân viên</span>
                    </a>
                    <a class="sidebar-item" href="#">
                        <span>Trợ lý trí tuệ nhân tạo</span>
                    </a>
                </div>
            </div>
        </div>
    </nav>
</div>