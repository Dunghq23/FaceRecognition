@extends('layouts.master')

@section('title', 'Phân quyền người dùng')

@push('css')
    <style>
        .d-inline-flex+.list-group:hover {
            cursor: pointer !important;
        }
    </style>
@endpush
@section('content')
    <div class="row g-0 p-3">
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item fw-medium"><a class="text-decoration-none" href="{{ route('home') }}">Trang chủ</a>
            </li>
            <li class="breadcrumb-item active fw-medium" aria-current="page">Phân quyền người dùng</li>
        </ol>
    </div>
    <x-dashboard-title text="Phân quyền người dùng" />
    <div class="row g-0 p-3">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="h5 fw-bold border-bottom pb-2 mb-3">
                        <i class="fa-solid fa-person-circle-check me-2"></i>
                        <span>Đăng ký vai trò</span>
                    </h5>
                    <div class="row">
                        <div class="input-group mb-3">
                            <label class="input-group-text" for="user-select">Người dùng</label>
                            <select class="form-select" id="user-select">
                                @foreach ($users as $user)
                                    <option value="{{ $user->account_id }}">{{ $user->username }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            @foreach ($roleParents as $key => $item)
                                <div class="role-item" id="roleItem{{ $key }}">
                                    <div class="p-3 px-0">
                                        <span data-bs-toggle="collapse" style="cursor: pointer !important;"
                                            data-bs-target="#collapseRole{{ $key }}" class="fw-bold">
                                            {{ $item->roleParent_name }}
                                        </span>
                                    </div>
                                    <ul class="list-group collapse cursor-pointer" id="collapseRole{{ $key }}"
                                        data-bs-parent="#accordion">
                                        @foreach ($item->roles as $role)
                                            <li class="list-group-item">
                                                <input class="form-check-input me-1 checkbox" type="checkbox" value=""
                                                    id="role{{ $role->role_id }}">
                                                <label class="form-check-label stretched-link"
                                                    for="role{{ $role->role_id }}">{{ $role->role_name }}</label>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="card-footer pt-0 border-0 bg-transparent">
                    <div class="d-flex align-items-center justify-content-end">
                        <button class="btn btn-outline-primary float-end" data-bs-toggle="modal" data-bs-target="#modalstart"
                            id="btnSave">Lưu lại</button>
                        <div class="modal fade" id="modalstart" tabindex="-1" aria-labelledby="exampleModalLabel"
                            aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title" id="exampleModalLabel">Xác nhận</h4>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        Bạn chắc chắn muốn đăng ký vai trò cho người dùng này?
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-bs-dismiss="modal">Đóng</button>
                                        <button type="button" class="btn btn-primary btn-primary" data-bs-dismiss="modal"
                                            id="btnConfirm">Xác nhận</button>
                                    </div>
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
    <script>
        $(document).ready(function() {
            var role_id = [];
            var checkbox_lst = $('.checkbox');
            $(document).on("change", ".checkbox", function() {
                let checkedValue = $(this).attr('id').match(/\d+/)[0];
                if ($(this).is(':checked')) {
                    role_id.push(checkedValue);
                } else {
                    role_id = role_id.filter(function(element) {
                        return element !== checkedValue;
                    });
                }
            });

            function showRolesByUser() {
                role_id = [];
                let user_id = $('#user-select').val();
                checkbox_lst.each(function() {
                    $(this).prop('checked', false);
                });
                $.ajax({
                    url: '/management/roles/showRoleByUser/',
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {
                        user_id: user_id,
                    },
                    success: function(response) {
                        // console.log(response);
                        let list_role = response;
                        list_role.forEach(element => {
                            if (element['fk_account_id'] == user_id) {
                                let role_chk = "role" + element['fk_role_id'];
                                $('#' + role_chk).prop('checked', true);
                                role_id.push(element['fk_role_id']);
                            }
                        });
                    },
                    error: function(xhr) {
                        console.log(xhr.responseText);
                        alert("Có lỗi xảy ra. Vui lòng thử lại sau.");
                    },
                });
            }

            $(document).on('change', '#user-select', showRolesByUser);
            showRolesByUser();

            $('#btnConfirm').on('click', function() {
                let user_id = $('#user-select').val();
                $.ajax({
                    url: '/management/roles/store/',
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {
                        role_id: role_id,
                        user_id: user_id,
                    },
                    success: function(response) {
                        // window.location.href = response.url;
                        ShowToast(response['status'], response['message'], 2500);
                    },
                    error: function(xhr) {
                        console.log(xhr.responseText);
                        alert("Có lỗi xảy ra. Vui lòng thử lại sau.");
                    },
                });
            });
        });
    </script>
@endpush
