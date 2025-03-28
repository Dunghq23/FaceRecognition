@extends('layouts.master')

@section('title', 'Tuyển dụng - Ứng viên')

@push('css')
<style>
    .table-responsive {
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
    }
    .table {
        width: 100%;
        white-space: nowrap;
    }
    .min-w-150 {
        min-width: 150px;
    }
    .min-w-200 {
        min-width: 200px;
    }
</style>
@endpush

@section('content')
    <div class="row g-0 p-3">
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item fw-medium"><a class="text-decoration-none" href="{{ route('home') }}">Trang chủ</a>
            </li>
            <li class="breadcrumb-item active fw-medium" aria-current="page">Ứng viên</li>
        </ol>
    </div>
    <div class="row g-0 px-3">
        <h4 class="dashboard-title rounded-3 h4 fw-bold m-0">
            Ứng viên
        </h4>
    </div>
    <div class="row g-0 p-3">
        <div class="d-flex justify-content-end align-items-center mb-3">
            {{-- <h4 class="mb-0">Tin tuyển dụng</h4> --}}
            <a href="{{ route('recruit.candidates.create') }}" class="btn btn-primary btnAdd" tabindex="1">
                <i class="fa-solid fa-plus me-2"></i>
                <span>Thêm mới ứng viên</span>
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
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th style="width: 40px">
                                    <input type="checkbox" class="form-check">
                                </th>
                                <th class="min-w-150">Họ và tên</th>
                                <th class="min-w-150">Số điện thoại</th>
                                <th class="min-w-200">Email</th>
                                <th class="min-w-150">Vị trí tuyển dụng</th>
                                <th class="min-w-200">Tin tuyển dụng</th>
                                <th class="min-w-150">Ngày ứng tuyển</th>
                                <th class="min-w-150">Nguồn ứng viên</th>
                                <th class="min-w-150">Trình độ đào tạo</th>
                                <th class="min-w-200">Nơi đào tạo</th>
                                <th class="min-w-150">Chuyên ngành</th>
                                <th class="min-w-150">Đơn vị sử dụng</th>
                                <th style="width: 100px">Thao tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($candidates as $candidate)
                                <tr>
                                    <td>
                                        <input type="checkbox" class="form-check">
                                    </td>
                                    <td>{{ $candidate->full_name }}</td>
                                    <td>{{ $candidate->phone }}</td>
                                    <td>{{ $candidate->email }}</td>
                                    <td>{{ $candidate->jobPost->role_hire }}</td>
                                    <td>{{ $candidate->jobPost->title }}</td>
                                    <td>{{ $candidate->apply_time }}</td>
                                    <td>{{ $candidate->origin->origin_name }}</td>
                                    <td>{{ $candidate->education_level }}</td>
                                    <td>{{ $candidate->education_place }}</td>
                                    <td>{{ $candidate->major }}</td>
                                    {{-- <td>{{ $candidate->jobPost-> }}</td> --}}
                                    <td class="text-center">
                                        <div class="dropdown">
                                            <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" id="dropdownMenuButton{{ $candidate->candidate_id }}" data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="fa-solid fa-ellipsis-vertical"></i>
                                            </button>
                                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton{{ $candidate->candidate_id }}">
                                                <li>
                                                    <a href="#" class="dropdown-item text-primary">
                                                        <i class="fa-solid fa-eye me-2"></i>Xem
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="{{ route('recruit.candidates.edit', $candidate->candidate_id) }}" class="dropdown-item text-warning">
                                                        <i class="fa-solid fa-pencil me-2"></i>Sửa
                                                    </a>
                                                </li>
                                                <li>
                                                    <button type="button" class="dropdown-item text-danger" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $candidate->candidate_id }}">
                                                        <i class="fa-solid fa-trash me-2"></i>Xóa
                                                    </button>
                                                </li>
                                            </ul>
                                        </div>
                                    
                                        <!-- Modal Xóa -->
                                        <div class="modal fade" id="deleteModal{{ $candidate->candidates_id }}" tabindex="-1" aria-labelledby="deleteModalLabel{{ $candidate->candidate_id }}" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="deleteModalLabel{{ $candidate->candidates_id }}">Xác nhận xóa</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        Bạn có chắc chắn muốn xóa ứng viên <strong>{{ $candidate->full_name }}</strong> không?
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                                                        <form action="{{ route('recruit.candidates.destroy', $candidate->candidates_id) }}" method="POST">
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
    </div>
@endsection
