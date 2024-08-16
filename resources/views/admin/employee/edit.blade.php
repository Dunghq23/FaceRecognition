@extends('layouts.master')

@section('title', 'Sửa nhân viên')

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
                <li class="breadcrumb-item active fw-medium" aria-current="page">Sửa</li>
            </ol>
        </div>

        <div class="row g-0">
            <h4 class="dashboard-title rounded-3 h4 fw-bold text-white">
                Chỉnh sửa thông tin
            </h4>
        </div>

        <div class="card mt-3">
            <div class="card-header">
                <h5>Thông tin nhân viên</h5>
            </div>
            <div class="card-body">
                @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                <form action="{{ route('admin.employee.update', $employee->employee_id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PATCH')

                    <div class="row">
                        <div class="col-md-3 ">
                            <div class="form-group w-100 d-flex justify-content-center">
                                <div class="image-preview">
                                    @if ($employee->profile_picture != null)
                                        <img id="image_preview" src="{{ $employee->profile_picture }}" alt="Ảnh đại diện">
                                    @else
                                        <img id="image_preview" src="https://cdn-icons-png.freepik.com/512/219/219986.png"
                                            alt="Ảnh đại diện">
                                    @endif
                                </div>
                            </div>
                            <div class="form-group mt-3 w-100 d-flex justify-content-center">
                                <label for="profile_picture" class="btn btn-outline-secondary">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                        fill="currentColor" class="bi bi-cloud-upload-fill" viewBox="0 0 16 16">
                                        <path fill-rule="evenodd"
                                            d="M8 0a5.53 5.53 0 0 0-3.594 1.342c-.766.66-1.321 1.52-1.464 2.383C1.266 4.095 0 5.555 0 7.318 0 9.366 1.708 11 3.781 11H7.5V5.707L5.354 7.854a.5.5 0 1 1-.708-.708l3-3a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1-.708.708L8.5 5.707V11h4.188C14.502 11 16 9.57 16 7.773c0-1.636-1.242-2.969-2.834-3.194C12.923 1.999 10.69 0 8 0m-.5 14.5V11h1v3.5a.5.5 0 0 1-1 0" />
                                    </svg>
                                    Tải ảnh lên
                                </label>
                                <input type="file" class="d-none" id="profile_picture" name="profile_picture"
                                    accept="image/*" onchange="previewImage(event)">
                            </div>
                        </div>
                        <div class="col-md-9">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="employee_username">Username</label>
                                        <input type="text" class="form-control" id="employee_username"
                                            name="employee_username" placeholder="angvan"
                                            value="{{ $employee->employee_username }}" required>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="employee_name">Họ và Tên</label>
                                        <input type="text" class="form-control" id="employee_name"
                                            placeholder="Nguyễn Văn A" name="employee_name"
                                            value="{{ $employee->employee_name }}" required>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="position">Chức Vụ</label>
                                        <input type="text" class="form-control" id="position"
                                            placeholder="Nhân viên kinh doanh" name="position"
                                            value="{{ $employee->position }}">
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="email">Email</label>
                                        <input type="email" class="form-control" id="email" name="email"
                                            value="{{ $employee->email }}" required>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="phone_number">Số Điện Thoại</label>
                                        <input type="text" class="form-control" id="phone_number" name="phone_number"
                                            value="{{ $employee->phone_number }}">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="address">Địa Chỉ</label>
                                        <input type="text" class="form-control" id="address" name="address"
                                            value="{{ $employee->address }}">
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="date_of_birth">Ngày Sinh</label>
                                        <input type="date" class="form-control" id="date_of_birth"
                                            name="date_of_birth" value="{{ $employee->date_of_birth }}">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="gender">Giới Tính</label>
                                        <select class="form-control" id="gender" name="gender">
                                            <option value="1" {{ $employee->gender == 1 ? 'selected' : '' }}>Nam
                                            </option>
                                            <option value="0" {{ $employee->gender == 0 ? 'selected' : '' }}>Nữ
                                            </option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="fk_department_id">Phòng Ban</label>
                                        <select class="form-control" id="fk_department_id" name="fk_department_id"
                                            required>
                                            @foreach ($departments as $department)
                                                <option value="{{ $department->department_id }}"
                                                    {{ $employee->fk_department_id == $department->department_id ? 'selected' : '' }}>
                                                    {{ $department->department_name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="start_date">Ngày Bắt Đầu Làm Việc</label>
                                        <input type="date" class="form-control" id="start_date" name="start_date"
                                            value="{{ $employee->start_date }}">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="salary">Mức Lương</label>
                                        <input type="number" class="form-control" id="salary" name="salary"
                                            step="0.01" value="{{ $employee->salary }}">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="employment_status">Trạng Thái Công Việc</label>
                                        <select class="form-control" id="employment_status" name="employment_status">
                                            <option value="1"
                                                {{ $employee->employment_status == 1 ? 'selected' : '' }}>Đang làm việc
                                            </option>
                                            <option value="0"
                                                {{ $employee->employment_status == 0 ? 'selected' : '' }}>Đã nghỉ việc
                                            </option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="notes">Ghi Chú</label>
                                <textarea class="form-control" id="notes" name="notes">{{ $employee->notes }}</textarea>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-12 d-flex justify-content-end">
                            <button type="button" class="btn btn-secondary me-2">
                                <a href="{{ route('admin.employee.index') }}"
                                    class="text-white text-decoration-none">Quay
                                    lại</a>
                            </button>
                            <button type="submit" class="btn btn-primary">Lưu</button>
                        </div>
                    </div>
                </form>

            </div>


        </div>
    @endsection

    @push('javascript')
        <!-- Thêm bất kỳ JavaScript tùy chỉnh nào ở đây nếu cần -->
    @endpush
