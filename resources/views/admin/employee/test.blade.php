@extends('layouts.master')

@section('title', 'Quản lý nhân viên')

@push('css')
@endpush

@section('content')
    <div class="container">
        <div class="row g-0 p-3">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a class="text-decoration-none" href="{{ route('home') }}">Trang chủ</a></li>
                <li class="breadcrumb-item active fw-medium" aria-current="page">Quản lý nhân viên</li>
            </ol>
        </div>

        <div class="row g-0">
            <h4 class="dashboard-title rounded-3 h4 fw-bold text-white">
                Quản lý nhân viên
            </h4>
        </div>

        <div class="row">
            <!-- Dropdown chọn Chi nhánh -->
            <div class="col-md-4">
                <div class="input-group mb-3">
                    <label class="input-group-text" for="branch">Chi nhánh</label>
                    <select class="form-control" id="branch" name="branch">
                        <option value="0">Cơ sở chính: 101 Láng Hạ, Đống Đa, Hà Nội</option>
                        <option value="1">TP. Hồ Chí Minh</option>
                        <option value="2">Xưởng Nguyên Khê - Đông Anh - Hà Nội</option>
                    </select>
                </div>
                <div class="input-group mb-3">
                    <label class="input-group-text" for="department">Phòng ban</label>
                    <select class="form-control" id="department" name="department">
                        <option value="0">Tất cả phòng ban</option>
                        @foreach ($departments as $department)
                            <option value="{{ $department->department_id }}">{{ $department->department_name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <!-- Dropdown chọn Phòng ban -->
            <div class="col-md-4">
                <!-- Card Tổng số nhân viên -->
                <div class="card text-white bg-success bg-gradient mb-3">
                    <div class="card-body">
                        <h5 class="card-title">Tổng số nhân viên chi nhánh</h5>
                        <p class="card-text">{{ $totalEmployees }} nhân viên</p>
                    </div>
                </div>
            </div>

            <!-- Card Nhân viên theo phòng ban -->
            {{-- @foreach ($departments as $department)
                <div class="col-md-4">
                    <div class="card text-white bg-body-tertiary mb-3 department-card d-none"
                        data-department-id="{{ $department->department_id }}">
                        <div class="card-body text-dark">
                            <h5 class="card-title">{{ $department->department_name }}</h5>
                            <p class="card-text">{{ $department->employees_count }} nhân viên</p>
                        </div>
                    </div>
                </div>
            @endforeach --}}

            <div class="col-md-4">
                <div id="department-cards-container"></div>

            </div>
        </div>

        <div class="card mt-3">
            <div class="card-header">
                <h4>Danh sách nhân viên</h4>
                <a href="{{ route('admin.employee.create') }}" class="btn btn-primary">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                        class="bi bi-person-add" viewBox="0 0 16 16">
                        <path
                            d="M12.5 16a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7m.5-5v1h1a.5.5 0 0 1 0 1h-1v1a.5.5 0 0 1-1 0v-1h-1a.5.5 0 0 1 0-1h1v-1a.5.5 0 0 1 1 0m-2-6a3 3 0 1 1-6 0 3 3 0 0 1 6 0M8 7a2 2 0 1 0 0-4 2 2 0 0 0 0 4" />
                        <path
                            d="M8.256 14a4.5 4.5 0 0 1-.229-1.004H3c.001-.246.154-.986.832-1.664C4.484 10.68 5.711 10 8 10q.39 0 .74.025c.226-.341.496-.65.804-.918Q8.844 9.002 8 9c-5 0-6 3-6 4s1 1 1 1z" />
                    </svg>
                    Thêm nhân viên
                </a>
            </div>

            <div class="card-body">
                <!-- Hiển thị thông báo lỗi nếu có -->
                @if (session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif

                <!-- Hiển thị thông báo thành công nếu có -->
                @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                <!-- Danh sách nhân viên -->
                <div id="employee-list">
                    <table class="table table-bordered">
                        <thead class="thead-dark">
                            <tr class="text-center">
                                <th>ID</th>
                                <th>Tên nhân viên</th>
                                <th>Giới tính</th>
                                <th>Chức vụ</th>
                                <th>Phòng ban</th>
                                <th>Hành động</th>
                            </tr>
                        </thead>
                        <tbody class="text-center align-middle">
                            
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
    </div>
@endsection

@push('javascript')
    <script>
        $(document).ready(function() {
            $('#department').change(function() {
                var selectedDepartmentId = $(this).val();
                // Xóa các card hiện tại
                $('.card-department').remove();

                // Gửi AJAX request để lấy danh sách nhân viên và phòng ban
                $.ajax({
                    url: '/admin/employees-by-department/' + selectedDepartmentId,
                    type: 'GET',
                    success: function(response) {
                        console.log(response); // Kiểm tra cấu trúc của data
                        var employees = response.employees;
                        var departments = response.departments;

                        // Xóa danh sách nhân viên hiện tại
                        $('#employee-list tbody').empty();

                        // Nếu không có nhân viên nào, hiển thị thông báo
                        if (employees.length === 0) {
                            $('#employee-list tbody').append(
                                '<tr><td colspan="6">Không có nhân viên nào trong phòng ban này.</td></tr>'
                            );
                        } else {
                            // // Duyệt qua danh sách nhân viên và thêm vào DOM
                            // $.each(employees, function(index, employee) {
                            //     var gender = employee.gender == 1 ? 'Nam' : 'Nữ';

                            //     // Tìm tên phòng ban dựa trên fk_department_id
                            //     var departmentName = '';
                            //     $.each(departments, function(i, department) {
                            //         if (employee.fk_department_id == department
                            //             .department_id) {
                            //             departmentName = department
                            //                 .department_name;
                            //             return false; // Thoát khỏi vòng lặp
                            //         }
                            //     });

                            //     var html =
                            //         `
                            //         <tr>
                            //             <td>${employee.employee_id}</td>
                            //             <td>${employee.employee_name}</td>
                            //             <td>${gender}</td>
                            //             <td>${employee.position}</td>
                            //             <td>${departmentName}</td>
                            //             <td>
                            //                 <a href="/admin/employee/${employee.employee_id}" class="btn btn-outline-success btn-sm">
                            //                     <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-eye" viewBox="0 0 16 16">
                            //                         <path d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8M1.173 8a13 13 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5s3.879 1.168 5.168 2.457A13 13 0 0 1 14.828 8q-.086.13-.195.288c-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5s-3.879-1.168-5.168-2.457A13 13 0 0 1 1.172 8z"/>
                            //                         <path d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5M4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0"/>
                            //                     </svg>
                            //                 </a>
                            //                 <a href="/admin/employee/${employee.employee_id}/edit" class="btn btn-outline-warning btn-sm">
                            //                     <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pen" viewBox="0 0 16 16">
                            //                         <path d="m13.498.795.149-.149a1.207 1.207 0 1 1 1.707 1.708l-.149.148a1.5 1.5 0 0 1-.059 2.059L4.854 14.854a.5.5 0 0 1-.233.131l-4 1a.5.5 0 0 1-.606-.606l1-4a.5.5 0 0 1 .131-.232l9.642-9.642a.5.5 0 0 0-.642.056L6.854 4.854a.5.5 0 1 1-.708-.708L9.44.854A1.5 1.5 0 0 1 11.5.796a1.5 1.5 0 0 1 1.998-.001m-.644.766a.5.5 0 0 0-.707 0L1.95 11.756l-.764 3.057 3.057-.764L14.44 3.854a.5.5 0 0 0 0-.708z"/>
                            //                     </svg>
                            //                 </a>
                            //                 <form action="/admin/employee/${employee.employee_id}" method="POST" style="display:inline;">
                            //                     @csrf
                            //                     @method('DELETE')
                            //                     <button type="button" class="btn btn-outline-danger btn-sm" data-toggle="modal" data-target="#deleteModal" data-id="${employee.employee_id}">
                            //                         <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                            //                             <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0z"/>
                            //                             <path d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4zM2.5 3h11V2h-11z"/>
                            //                         </svg>
                            //                     </button>
                            //                 </form>
                            //             </td>
                            //         </tr>
                            //     `;

                                $('#employee-list tbody').append(`<x-employee-row :departmentId="${selectedDepartmentId}" />`);
                                
                            // });

                            // Tạo HTML cho các card dựa trên dữ liệu nhận được
                            $.each(departments, function(i, department) {
                                if (department.department_id == selectedDepartmentId) {
                                    var htmlDepartment = `
                                        <div class="card text-white bg-body-tertiary mb-3 card-department d-block">
                                            <div class="card-body text-dark">
                                                <h5 class="card-title">${department.department_name}</h5>
                                                <p class="card-text">${department.employees_count} nhân viên</p>
                                            </div>
                                        </div>
                                    `;
                                    $('#department-cards-container').append(
                                        htmlDepartment);
                                }
                            });
                        }
                    },
                    error: function(xhr, status, error) {
                        console.log('Lỗi:', error);
                    }
                });
            });

            $('#department').trigger('change');
        });
    </script>
@endpush
