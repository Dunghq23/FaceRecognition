@extends('layouts.master')

@section('title', 'Quản lý người dùng')

@section('content')
    <div class="row g-0 p-3">
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item fw-medium"><a class="text-decoration-none" href="{{ route('home') }}">Trang chủ</a>
            </li>
            <li class="breadcrumb-item active fw-medium" aria-current="page">Quản lý người dùng</li>
        </ol>
    </div>
    <div class="row g-0 px-3">
        <h4 class="dashboard-title rounded-3 h4 fw-bold m-0">
            Quản lý người dùng
        </h4>
    </div>
    <div class="row g-0 p-3">
        <div class="col-md-12">
            <div class="card py-3 gap-3">
                <div class="card-header px-3 py-0 border-0 bg-transparent">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <a href="{{ route('management.users.create') }}" class="btn btn-primary btnAdd" tabindex="1">
                                <i class="fa-solid fa-plus me-2"></i>
                                <span>Thêm người dùng</span>
                            </a>
                        </div>
                        <div class="d-flex justify-content-end align-items-center gap-3">
                            {{-- <div>
                                <button type="button" class="btn btn-outline-danger" data-bs-toggle="modal"
                                    data-bs-target="#deleteUser" tabindex="2">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                                <div class="modal fade" id="deleteUser" tabindex="-1" aria-labelledby="exampleModalLabel"
                                    aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title" id="exampleModalLabel">Xác
                                                    nhận
                                                    </h1>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                Bạn có chắc chắn muốn xóa những người dùng đã chọn ?
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-bs-dismiss="modal">Hủy</button>
                                                <button type="button" id="btnDelete" class="btn btn-danger">Xác
                                                    nhận</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div> --}}
                            <div>
                                <input type="text" id="keySearch" name="search" class="form-control"
                                    placeholder="Tìm kiếm người dùng" tabindex="3">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body p-0">
                    <table class="table table-borderless table-hover m-0">
                        <thead class="table-info">
                            <tr class="align-middle">
                                <th scope="col" class="py-2 text-center"></th>
                                <th scope="col" class="py-2 text-center">#</th>
                                <th scope="col" class="py-2">Tài khoản</th>
                                <th scope="col" class="py-2">Người sử dụng</th>
                                <th scope="col" class="py-2 text-center">Vai trò</th>
                                <th scope="col" class="py-2 text-center">Hoạt động</th>
                            </tr>
                        </thead>
                        <tbody id="table-data">
                            @foreach ($data as $user)
                                <tr class="align-middle">
                                    <td class="text-center" data-id="Id_User" data-value="{{ $user->account_id }}">
                                        <input type="checkbox" class="form-check-input" data-id="{{ $user->account_id }}">
                                    </td>
                                    <th scope="row" class="text-center text-body-secondary">
                                        {{ $user->account_id }}
                                    </th>
                                    <td>{{ $user->username }}</td>
                                    <td>{{ $user->employee->employee_name }}</td>
                                    <td class="text-center">
                                        <button type="button" class="btn btn-sm btn-outline-primary btnShow" data-bs-toggle="modal"
                                            data-bs-target="#role-{{ $user->account_id }}"
                                            data-id="{{ $user->account_id }}">
                                            <i class="fa-solid fa-eye"></i>
                                        </button>
                                        <div class="modal fade" id="role-{{ $user->account_id }}" tabindex="-1"
                                            aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h4 class="modal-title" id="exampleModalLabel">Vai trò của
                                                            người dùng {{ $user->employee->employee_name }}
                                                        </h4>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body overflow-y-auto" style="height: 250px">
                                                        @if ($user->roles->isEmpty())
                                                            Người dùng chưa được cấp vai trò
                                                        @else
                                                            <div class="table-responsive">
                                                                <table class="table table-hover m-0">
                                                                    <thead class="table-info">
                                                                        <tr class="align-middle">
                                                                            <th scope="col" class="text-start py-2">
                                                                                Tên vai trò
                                                                            </th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        @foreach ($user->roles as $role)
                                                                            <tr class="align-middle">
                                                                                <td class="text-start">
                                                                                    {{ $role->role_name }}
                                                                                </td>
                                                                            </tr>
                                                                        @endforeach
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        @endif
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-bs-dismiss="modal">Đóng</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <a href="{{ route('management.users.edit', $user->account_id) }}"
                                            class="btn btn-sm btn-outline-warning btn_edit">
                                            <i class="fa-solid fa-pencil"></i>
                                        </a>
                                        @if ($user->account_id != Auth::user()->account_id)
                                            <button type="button" class="btn btn-sm btn-outline-danger" data-bs-toggle="modal"
                                                data-bs-target="#i{{ $user->account_id }}">
                                                <i class="fa-solid fa-trash"></i>
                                            </button>
                                        @endif
                                        <div class="modal fade" id="i{{ $user->account_id }}" tabindex="-1"
                                            aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h4 class="modal-title" id="exampleModalLabel">Xác nhận
                                                            </h1>
                                                            <button type="button" class="btn-close"
                                                                data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <p class="m-0">Bạn chắc chắn muốn xóa người dùng này?</p>
                                                        <p class="m-0">
                                                            Việc này sẽ xóa người dùng vĩnh viễn. <br>
                                                            Hãy chắc chắn trước khi tiếp tục.
                                                        </p>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-bs-dismiss="modal">Hủy</button>
                                                        <form
                                                            action="{{ route('management.users.destroy', $user->account_id) }}"
                                                            method="POST">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-danger">Xác
                                                                nhận</button>
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
                @if ($data->lastPage() > 1)
                    <div class="card-footer border-0 bg-transparent">
                        <nav>
                            {{ $data->links('components.pagination') }}
                        </nav>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection

@push('javascript')
    <script type="text/javascript">
        $(document).ready(function() {
            $("#btnDelete").on('click', function() {
                let modalElement = $("#deleteUser");
                let rowElements = $("#table-data tr");
                let rowDataArray = [];
                let isValid = false;
                rowElements.each(function() {
                    if ($(this).find("input[type=checkbox]").prop("checked") === true) {
                        let rowData = {};
                        rowData.Id_User = $(this)
                            .find('td[data-id="Id_User"]')
                            .data("value");
                        rowDataArray.push(rowData);
                        isValid = true;
                    }
                });
                if (isValid) {
                    $.ajax({
                        url: "/users/destroyUsers",
                        type: "post",
                        data: {
                            rowData: rowDataArray,
                            _token: window.csrfToken,
                        },
                        success: function(response) {
                            rowElements.each(function() {
                                if (
                                    $(this)
                                    .find("input[type=checkbox]")
                                    .prop("checked") === true
                                ) {
                                    $(this).remove();
                                }

                                showToast(
                                    "Xóa người dùng thành công",
                                    "success",
                                );
                                modalElement.modal('hide');
                            });
                        },
                        error: function(xhr) {
                            // Xử lý lỗi khi gửi yêu cầu Ajax
                            console.log(xhr.responseText);
                            alert("Có lỗi xảy ra. Vui lòng thử lại sau.");
                        },
                    });
                } else {
                    showToast(
                        "Vui lòng chọn người dùng",
                        "warning",
                    );
                    modalElement.modal('hide');
                }
            })

            $("#keySearch").on('keyup', function() {
                let searchValue = $(this).val();
                $.ajax({
                    url: "/management/users/searchUsers",
                    type: "POST",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {
                        searchValue: searchValue
                    },
                    success: function(response) {
                        let table = $("#table-data");
                        table.html('');
                        let html = '';
                        console.log(response);
                        
                        response.forEach((each) => {
                            html = `<tr class="align-middle">
                                        <td class="text-center" data-id="Id_User" data-value="${each.account_id}">
                                            <input type="checkbox" class="form-check-input" data-id="${each.account_id}">
                                        </td>
                                        <td class="text-center">${each.account_id}</td>
                                        <td>${each.username}</td>
                                        <td>${each.name}</td>
                                        <td class="text-center">
                                            <button type="button" class="btn btn-sm btn-outline-primary btnShow" data-bs-toggle="modal"
                                            data-bs-target="#role-${each.account_id}" data-id="${each.account_id}">
                                            <i class="fa-solid fa-eye"></i>
                                            </button>
                                            <div class="modal fade" id="role-${each.account_id}" tabindex="-1" aria-labelledby="exampleModalLabel"
                                            aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h4 class="modal-title" id="exampleModalLabel">Vai trò của người dùng ${each.Name}
                                                            </h4>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body overflow-y-auto" style="height: 250px">
                                                            <div class="table-responsive">
                                                                <table class="table table-hover m-0">
                                                                    <thead class="table-info">
                                                                        <tr class="align-middle">
                                                                            <th scope="col" class="text-start py-2">Tên vai trò</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody id="table-roles">
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            <a href="/users/${each.account_id}/edit" class="btn btn-sm btn-outline-warning btn_edit">
                                                <i class="fa-solid fa-pencil"></i>
                                            </a>
                                            <button type="button" class="btn btn-sm btn-outline-danger" data-bs-toggle="modal"
                                            data-bs-target="#i${each.account_id}">
                                                <i class="fa-solid fa-trash"></i>
                                            </button>
                                            <div class="modal fade" id="i${each.account_id}" tabindex="-1" aria-labelledby="exampleModalLabel"
                                            aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h4 class="modal-title" id="exampleModalLabel">Xác nhận
                                                            </h1>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <p class="m-0">Bạn chắc chắn muốn xóa người dùng này?</p>
                                                            <p class="m-0">
                                                                Việc này sẽ xóa người dùng vĩnh viễn. <br>
                                                                Hãy chắc chắn trước khi tiếp tục.
                                                            </p>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                                                            <form action="management/users/${each.account_id}" method="POST">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-danger">Xác nhận</button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>`
                            table.append(html);
                        })
                    },
                    error: function(xhr) {
                        // Xử lý lỗi khi gửi yêu cầu Ajax
                        console.log(xhr.responseText);
                        alert("Có lỗi xảy ra. Vui lòng thử lại sau.");
                    },
                });
            })

            let count = 0;
            let maxTabIndex = Math.max.apply(null, $("*").map(function() {
                let tabIndex = $(this).attr("tabindex");
                return tabIndex ? parseInt(tabIndex, 10) : -Infinity;
            }).get());
        })
    </script>
@endpush
