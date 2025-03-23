@extends('layouts.master')

@section('title', 'Thêm người dùng mới')

@section('content')
    <div class="row g-0 p-3">
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item fw-medium"><a class="text-decoration-none" href="{{ route('home') }}">Trang chủ</a>
            </li>
            <li class="breadcrumb-item fw-medium"><a class="text-decoration-none" href="{{ route('management.users.index') }}">Quản lý
                    người
                    dùng</a>
            </li>
            <li class="breadcrumb-item active fw-medium" aria-current="page">
                Thêm
            </li>
        </ol>
    </div>
    <x-dashboard-title text="Thêm người dùng" />
    <div class="row g-0 p-3">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body p-3">
                    <h5 class="h5 fw-bold border-bottom pb-2 mb-3">
                        Thông tin người dùng
                    </h5>
                    <form id="formInformation" method="POST" action="{{ route('management.users.store') }}">
                        @csrf
                        <div class="mb-3">
                            <div class="form-group">
                                <label for="Name" class="form-label">
                                    Tên người dùng
                                </label>
                                <input type="text" class="form-control{{ $errors->has('Name') ? ' is-invalid' : '' }}"
                                    id="Name" name="Name" placeholder="Nhập tên người dùng"
                                    value="{{ $user->Name ?? old('Name') }}" tabindex="1">
                            </div>
                            <span class="text-danger">
                                @if ($errors->has('Name'))
                                    {{ $errors->first('Name') }}
                                @endif
                            </span>
                        </div>
                        <div class="mb-3">
                            <div class="form-group">
                                <label for="UserName" class="form-label">
                                    Tên đăng nhập
                                </label>
                                <input type="text"
                                    class="form-control{{ $errors->has('UserName') ? ' is-invalid' : '' }}" id="UserName"
                                    name="UserName" placeholder="Nhập tài khoản"
                                    value="{{ $user->UserName ?? old('UserName') }}" tabindex="2">
                            </div>
                            <span class="text-danger">
                                @if ($errors->has('UserName'))
                                    {{ $errors->first('UserName') }}
                                @endif
                            </span>
                        </div>
                        <div class="d-flex justify-content-end gap-3">
                            <button class="btn btn-primary" type="submit" tabindex="4">Lưu</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('javascript')
    {{-- <script src="{{ asset('js/app.js') }}"></script> --}}
    <script>
        function validateInput(element, message = null) {
            $(element).on('blur', function() {
                if ($(this).val() == "") {
                    $(this).parent().next().show();
                    $(this).addClass("is-invalid");
                    $(this).parent().next().text(message);
                } else {
                    if ($(this).attr("id") == "Name") {
                        if (!/^[a-zA-ZÀ-ỹ\s]+$/.test($(this).val())) {
                            $(this).addClass("is-invalid");
                            $(this).parent().next().text("Tên đầy đủ không hợp lệ, vui lòng nhập đúng định dạng");
                            $(this).parent().next().show();
                        } else {
                            $(this).parent().next().hide();
                            $(this).removeClass("is-invalid");
                        }
                    } else if ($(this).attr("id") == "UserName") {
                        if (!/^(?=[a-zA-Z0-9._]{8,20}$)(?!.*[_.]{2})[^_.].*[^_.]$/.test($(this).val())) {
                            $(this).addClass("is-invalid");
                            $(this).parent().next().text(
                                "Tên người dùng không hợp lệ. Tên người dùng phải chứa ít nhất 8 ký tự và không có kí tự đặc biệt."
                            );
                            $(this).parent().next().show();
                        } else {
                            $(this).parent().next().hide();
                            $(this).removeClass("is-invalid");
                        }
                    } else if ($(this).attr("id") == "Password") {
                        if (!/(?=^.{8,}$)((?=.*\d)|(?=.*\W+))(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$/
                            .test($(this).val())) {
                            $(this).addClass("is-invalid");
                            $(this).parent().next().text(
                                "Mật khẩu không hợp lệ. Mật khẩu phải chứa ít nhất 8 ký tự, bao gồm ít nhất một chữ cái viết hoa, một chữ cái viết thường, một số, và một ký tự đặc biệt"
                            );
                            $(this).parent().next().show();
                        } else {
                            $(this).parent().next().hide();
                            $(this).removeClass("is-invalid");
                        }
                    } else {
                        $(this).parent().next().hide();
                        $(this).removeClass("is-invalid");
                    }
                }
            });
        }

        $(document).ready(function() {
            validateInput("#Name", "Vui lòng nhập tên người dùng");
            validateInput("#UserName", "Vui lòng nhập tên đăng nhập");
            validateInput("#Password", "Vui lòng nhập mật khẩu");

            $("#formInformation").on('submit', function(event) {
                event.preventDefault();
                let isValid = true;

                $("#formInformation")
                    .find(".form-control")
                    .each(function() {
                        if ($(this).hasClass("is-invalid")) {
                            isValid = false;
                        } else if ($(this).val() == "") {
                            isValid = false;
                            $(this).addClass("is-invalid");
                            $(this).parent().next().text("Trường này là bắt buộc");
                            $(this).parent().next().show();
                        }
                    });

                if (isValid) {
                    this.submit();
                }
            })
        })
    </script>
@endpush
