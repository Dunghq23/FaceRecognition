@extends('layouts.master')

@section('title', 'Tuyển dụng - Tin tuyển dụng')

@section('content')
    <div class="row g-0 p-3">
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item fw-medium"><a class="text-decoration-none" href="{{ route('home') }}">Trang chủ</a>
            </li>
            <li class="breadcrumb-item active fw-medium" aria-current="page">Tin tuyển dụng</li>
        </ol>
    </div>
    <div class="row g-0 px-3">
        <h4 class="dashboard-title rounded-3 h4 fw-bold m-0">
            Tin tuyển dụng
        </h4>
    </div>
    <div class="row g-0 p-3">
        <div class="d-flex justify-content-end align-items-center mb-3">
            {{-- <h4 class="mb-0">Tin tuyển dụng</h4> --}}
            <a href="{{ route('recruit.jobs.create') }}" class="btn btn-primary btnAdd" tabindex="1">
                <i class="fa-solid fa-plus me-2"></i>
                <span>Thêm mới tin</span>
            </a>
        </div>
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between mb-3">
                    <div class="d-flex align-items-center gap-2">
                        <select id="filter_status" class="form-select" style="width: auto; font-size: 14px">
                            <option value="">Tất cả</option>
                            <option value="0">Đang tuyển dụng</option>
                            <option value="1">Tạm dừng nhận hồ sơ</option>
                            <option value="2">Đóng tuyển dụng</option>
                        </select>
                        <select id="filter_orderBy" class="form-select" style="width: auto; font-size: 14px">
                            <option>Sắp xếp theo</option>
                            <option value="created_at">Ngày tạo</option>
                            <option value="title">Tiêu đề</option>
                        </select>
                    </div>
                    <div style="width: 250px">
                        <input type="text" style="font-size: 14px" id="keySearch" name="search" class="form-control"
                            placeholder="Tìm kiếm nhật ký thao tác" tabindex="3">
                    </div>
                </div>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Tiêu đề</th>
                            <th>Vị trí</th>
                            <th>Người phụ trách</th>
                            <th>SL cần tuyển</th>
                            <th>Hạn nộp hồ sơ</th>
                            {{-- <th>Chờ phỏng vấn</th> --}}
                            <th>Đang phỏng vấn</th>
                            <th>Đã tuyển</th>
                            {{-- <th>Đã trượt</th> --}}
                            <th>Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($jobPosts as $jobPost)
                            <tr>
                                <td>{{ $jobPost->title }}</td>
                                <td>{{ $jobPost->role_hire }}</td>
                                <td>{{ $jobPost->employee->employee_name }}</td>
                                <td>{{ $jobPost->quantity_hire }}</td>
                                <td>{{ $jobPost->formatted_expiried_date }}</td>
                                {{-- <td>{{ $jobPost->interviewer_pending }}</td> --}}
                                <td>{{ $jobPost->interviewing }}</td>
                                <td>{{ $jobPost->interviewer_passed }}</td>
                                {{-- <td>{{ $jobPost->interviewer_failed() }}</td> --}}
                                <td class="text-center">
                                    <div class="dropdown">
                                        <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" id="dropdownMenuButton{{ $jobPost->jobPost_id }}" data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="fa-solid fa-ellipsis-vertical"></i>
                                        </button>
                                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton{{ $jobPost->jobPost_id }}">
                                            <li>
                                                <a href="#" class="dropdown-item text-primary">
                                                    <i class="fa-solid fa-eye me-2"></i>Xem
                                                </a>
                                            </li>
                                            <li>
                                                <a href="{{ route('recruit.jobs.edit', $jobPost->jobPost_id) }}" class="dropdown-item text-warning">
                                                    <i class="fa-solid fa-pencil me-2"></i>Sửa
                                                </a>
                                            </li>
                                            <li>
                                                <button type="button" class="dropdown-item text-danger" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $jobPost->jobPost_id }}">
                                                    <i class="fa-solid fa-trash me-2"></i>Xóa
                                                </button>
                                            </li>
                                        </ul>
                                    </div>
                                
                                    <!-- Modal Xóa -->
                                    <div class="modal fade" id="deleteModal{{ $jobPost->jobPost_id }}" tabindex="-1" aria-labelledby="deleteModalLabel{{ $jobPost->jobPost_id }}" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="deleteModalLabel{{ $jobPost->jobPost_id }}">Xác nhận xóa</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    Bạn có chắc chắn muốn xóa tin tuyển dụng <strong>{{ $jobPost->title }}</strong> không?
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                                                    <form action="{{ route('recruit.jobs.destroy', $jobPost->jobPost_id) }}" method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger">Xóa</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
