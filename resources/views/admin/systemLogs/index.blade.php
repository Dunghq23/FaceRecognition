@extends('layouts.master')

@section('title', 'Nhật ký thao tác hệ thống')

@section('content')
    <div class="row g-0 p-3">
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item fw-medium"><a class="text-decoration-none" href="{{ route('home') }}">Trang chủ</a>
            </li>
            <li class="breadcrumb-item active fw-medium" aria-current="page">Nhật ký thao tác hệ thống</li>
        </ol>
    </div>
    <div class="row g-0 px-3">
        <h4 class="dashboard-title rounded-3 h4 fw-bold m-0">
            Nhật ký thao tác hệ thống
        </h4>
    </div>
    <div class="row g-0 p-3">
        <div class="col-md-12">
            <div class="card py-3 gap-3">
                <div class="card-header px-3 py-0 border-0 bg-transparent">
                    <div class="row d-flex justify-content-center align-items-center">
                        <div class="col-2">
                            <select class="form-select {{ $access == true ? '' : 'd-none' }}" style="font-size: 14px" id="select-account" tabindex="1">
                                <option value="0">Tất cả</option>
                                @foreach ($accounts as $account)
                                    <option value="{{ $account->account_id }}">{{ $account->username }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-6"></div>
                        <div class="col-4">
                            <div class="d-flex justify-content-end">
                                <div style="width: 250px">
                                    <input type="text" style="font-size: 14px" id="keySearch" name="search" class="form-control"
                                        placeholder="Tìm kiếm nhật ký thao tác" tabindex="3">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body p-0">
                    <table class="table table-borderless table-hover m-0">
                        <thead class="table-info">
                            <tr class="align-middle">
                                <th scope="col" class="py-2 text-center">#</th>
                                <th scope="col" class="py-2">Tài khoản</th>
                                <th scope="col" class="py-2">Người sử dụng</th>
                                <th scope="col" class="py-2 text-center">Thao tác</th>
                                <th scope="col" class="py-2 text-center">Thời gian</th>
                            </tr>
                        </thead>
                        <tbody id="table-data">
                            @foreach ($logs as $key => $log)
                                <tr class="align-middle">
                                    <th scope="row" class="text-center text-body-secondary">
                                        {{ $log->log_id }}
                                    </th>
                                    <td>{{ $log->account->username }}</td>
                                    <td>{{ $log->account->employee->employee_name }}</td>
                                    <td class="text-center">{{ $log->action }}</td>
                                    <td class="text-center">{{ $log->getTime() }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @if ($logs->lastPage() > 1)
                    <div class="card-footer border-0 bg-transparent">
                        <nav>
                            {{ $logs->links('components.pagination') }}
                        </nav>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection

@push('javascript')
    <script src="{{ asset('general/js/admin/systemlogs.js') }}"></script>
@endpush
