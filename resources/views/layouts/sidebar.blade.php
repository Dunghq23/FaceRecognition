<div class="left-side-menu">
    <nav class="sidebar-wrapped px-4 py-1">
        <div class="sidebar">
            <div class="sidebar-group">
                <a class="sidebar-item{{ request()->is('/') ? ' active' : '' }}" href="{{route('home')}}">
                    <span>Trang chủ</span>
                </a>
            </div>
            <div class="sidebar-group">
                <h6 class="sidebar-title">Dữ liệu khuôn mặt</h6>
                <a class="sidebar-item{{ Str::startsWith(request()->url(), url('/customers')) ? ' active' : '' }}"
                    href="{{route('trainface.index')}}">
                    <span>Thêm dữ liệu khuôn mặt</span>
                </a>
                <a class="sidebar-item{{ Str::startsWith(request()->url(), url('/rawMaterials')) ? ' active' : '' }}"
                    href="{{route('recognition.index')}}">
                    Khuôn mặt chưa được nhận diện
                </a>
            </div>
            <div class="sidebar-group">
                <h6 class="sidebar-title">Công việc</h6>
                <a class="sidebar-item{{ Str::startsWith(request()->url(), url('/orderLocals/makes')) ? ' active' : '' }}"
                    href="{{route('timekeeping.index')}}"> Chấm công
                </a>
            </div>
        </div>
    </nav>
</div>
