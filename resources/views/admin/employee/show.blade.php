@extends('layouts.master')

@section('title', 'Thông tin chi tiết')

@push('css')
    <style>
        .image-preview {
            width: 80%;
            /* Đặt chiều rộng khung bằng 80% của phần tử chứa */
            height: 0;
            padding-bottom: 80%;
            /* Tạo tỷ lệ 1:1 để khung có dạng hình vuông */
            position: relative;
            /* Để ảnh có thể được căn giữa trong khung */
            overflow: hidden;
            border-radius: 50%;
            /* Tạo hình tròn cho khung */
            border: 1px solid #ddd;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .image-preview img {
            position: absolute;
            /* Để ảnh có thể nằm chính giữa khung */
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 100%;
            height: 100%;
            object-fit: cover;
            /* Đảm bảo ảnh không bị biến dạng */
        }
    </style>
@endpush

@section('content')
    <div class="container">
        <div class="row g-0 p-3">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a class="text-decoration-none" href="{{ route('home') }}">Trang chủ</a></li>
                <li class="breadcrumb-item">
                    <a class="text-decoration-none" href="{{ route('admin.employee.index') }}">Quản lý nhân viên</a>
                </li>
                <li class="breadcrumb-item active fw-medium" aria-current="page">Thông tin nhân viên</li>
            </ol>
        </div>

        <div class="row g-0">
            <h4 class="dashboard-title rounded-3 h4 fw-bold text-white">
                Hồ sơ nhân viên
            </h4>
        </div>


        <div class="card">
            <div class="row">
                <div class="d-flex align-items-center justify-content-center">
                    <div class="col-md-3">
                        <div class="form-group w-100 d-flex justify-content-center p-3">
                            <div class="image-preview">
                                @if ($employee->profile_picture != null)
                                    <img id="image_preview" src="{{ $employee->profile_picture }}" alt="Ảnh đại diện">
                                @else
                                    <img id="image_preview" src="https://cdn-icons-png.freepik.com/512/219/219986.png"
                                        alt="Ảnh đại diện">
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="col-md-9 d-flex flex-column justify-content-center">
                        <h1>{{ $employee->employee_name }}</h1>
                        <h3 style="color: #aaa;">{{ $employee->position }}</h3>
                    </div>
                </div>
            </div>

            <div class="row p-3">
                <!-- Card Thông tin liên hệ -->
                <div class="col-md-4">
                    <div class="card mb-3">
                        <div class="card-header">
                            <h4 class="card-title">Thông tin liên hệ</h4>
                        </div>
                        <div class="card-body">
                            <div class="row mb-2">
                                <div class="col-md-5">
                                    <p class="fw-bold">Số điện thoại</p>
                                </div>
                                <div class="col-md-7">{{ $employee->employee_name }}</div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-md-5">
                                    <p class="fw-bold">Email</p>
                                </div>
                                <div class="col-md-7">{{ $employee->email }}</div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-md-5">
                                    <p class="fw-bold">Địa chỉ</p>
                                </div>
                                <div class="col-md-7">{{ $employee->address }}</div>
                            </div>
                        </div>
                    </div>
                    <div class="card mb-3">
                        <div class="card-header">
                            <h4 class="card-title">Thông tin thêm</h4>
                        </div>
                        <div class="card-body">
                            <div class="row mb-2">
                                <div class="col-md-12">
                                    <p class="fw-bold">Ghi chú</p>
                                </div>
                                <div class="col-md-12">{{ $employee->notes }}</div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Card Thông tin chung -->
                <div class="col-md-8">
                    <div class="card mb-3">
                        <div class="card-header">
                            <h4 class="card-title">Thông tin chung</h4>
                        </div>
                        <div class="card-body">
                            <div class="row mb-2">
                                <div class="col-md-4">
                                    <p class="fw-bold">ID</p>
                                </div>
                                <div class="col-md-8">{{ $employee->employee_id }}</div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-md-4">
                                    <p class="fw-bold">Username</p>
                                </div>
                                <div class="col-md-8">{{ $employee->employee_username }}</div>
                            </div>

                            <div class="row mb-2">
                                <div class="col-md-4">
                                    <p class="fw-bold">Ngày sinh</p>
                                </div>
                                <div class="col-md-8">{{ $employee->date_of_birth }}</div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-md-4">
                                    <p class="fw-bold">Giới tính</p>
                                </div>
                                <div class="col-md-8">
                                     @if ($employee->gender)
                                        Nam
                                    @else
                                        Nữ
                                    @endif
                                </div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-md-4">
                                    <p class="fw-bold">Phòng ban</p>
                                </div>
                                <div class="col-md-8">
                                    @foreach ($departments as $department)
                                        @if ($employee->fk_department_id == $department->department_id)
                                            {{ $department->department_name }}
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-md-4">
                                    <p class="fw-bold">Mức lương</p>
                                </div>
                                <div class="col-md-8">{{ $employee->salary }} VNĐ</div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-md-4">
                                    <p class="fw-bold">Ngày bắt đầu làm việc</p>
                                </div>
                                <div class="col-md-8">{{ $employee->start_date }}</div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-md-4">
                                    <p class="fw-bold">Trạng thái công việc</p>
                                </div>
                                <div class="col-md-8">
                                    @if ($employee->employment_status)
                                        <span class="text-success fw-bold">Đang làm việc</span>
                                    @else
                                        <span class="text-secondary fw-bold">Đã nghỉ việc</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>



    </div>
@endsection

@push('javascript')
    <!-- Thêm bất kỳ JavaScript tùy chỉnh nào ở đây nếu cần -->
@endpush
