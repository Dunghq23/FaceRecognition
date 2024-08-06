<div class="navbar-custom bg-white fixed-top">
    <div class="text-center p-3">
        <a href="{{route('home')}}" class="text-center">
            <img src="{{ asset('Assets/images/logo.jpg') }}" alt="" height="55" class="object-fit-cover">
        </a>
    </div>
    {{-- <div class="d-flex align-items-center justify-content-center">
        <div class="notification-list">
            <a class="nav-user py-3 px-2 d-flex gap-2" href="#">
                <div class="account-avatar">
                    <span>{{ session('firstCharacter') }}</span>
                </div>
                <div class="d-flex flex-column ms-1 text-start">
                    <span class="account-name">
                        {{ session('name') }}
                        <i class="fa-solid fa-angle-down"></i>
                    </span>
                    <span class="account-username">{{ session('username') }}</span>
                </div>
            </a>
            <div class="dropdown-menu">
                <a class="dropdown-item" href="">
                    <span>Đăng xuất</span>
                </a>
            </div>
        </div>
    </div> --}}
</div>
