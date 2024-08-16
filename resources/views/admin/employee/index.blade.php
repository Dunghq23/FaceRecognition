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
                            {{-- <x-employee-row :departmentId="0" /> --}}
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>

    <!-- Modal xác nhận xóa -->
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">Xác nhận xóa</h5>
                    <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Bạn có chắc chắn muốn xóa nhân viên này? Hành động này không thể hoàn tác.
                </div>
                <div class="modal-footer">
                    <form id="deleteForm" method="POST" action="">
                        @csrf
                        @method('DELETE')
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Hủy</button>
                        <button type="submit" class="btn btn-danger">Xóa</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('javascript')
    <script script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#department').change(function() {
                var selectedDepartmentId = $(this).val();
                $('#department-cards-container').empty();
                $.ajax({
                    url: '/admin/employees-by-department/' + selectedDepartmentId,
                    method: 'GET',
                    success: function(response) {
                        // Cập nhật nội dung bảng với dữ liệu nhận được
                        $('#employee-list tbody').html(response.employeeHtml);

                        // Nếu phòng ban tồn tại trong response
                        if (response.department) {
                            var htmlDepartment = `
                                <div class="card text-white bg-body-tertiary mb-3 card-department d-block">
                                    <div class="card-body text-dark">
                                        <h5 class="card-title">${response.department.department_name}</h5>
                                        <p class="card-text">${response.department.employees_count} nhân viên</p>
                                    </div>
                                </div>
                                `;
                            $('#department-cards-container').html(htmlDepartment);
                        }
                    },
                    error: function() {
                        alert('Có lỗi xảy ra khi tải dữ liệu.');
                    }
                });
            });

            $('#department').trigger('change');

            $('#deleteModal').on('show.bs.modal', function(event) {
                var button = $(event.relatedTarget); // Button that triggered the modal
                var employeeId = button.data('id'); // Extract info from data-* attributes
                var actionUrl = '{{ url('admin/employee') }}/' + employeeId; // Set form action URL

                var form = $(this).find('#deleteForm');
                form.attr('action', actionUrl);
            });
        });
    </script>
@endpush
