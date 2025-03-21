@extends('layouts.master')

@section('title', 'Đăng nhập')

@push('css')
    <style>
        body {
            background-color: #fafafa;
        }

        #video {
            transform: scaleX(-1);
        }

        .login-card {
            background: white;
            border: none;
            border-radius: 15px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.08);
            width: 100%;
            max-width: 450px;
            margin: 0 auto;
        }

        .login-header {
            background: white;
            border-bottom: 1px solid #f1f1f1;
            border-radius: 15px 15px 0 0;
        }

        .btn-face-login {
            background-color: #011e41;
            border: none;
            color: white;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .btn-face-login:hover {
            background-color: #022b5c;
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(1, 30, 65, 0.3);
        }

        .btn-face-login:active {
            background-color: #011733;
            transform: translateY(0);
            box-shadow: 0 2px 8px rgba(1, 30, 65, 0.2);
        }

        .btn-face-login::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(120deg,
                    transparent,
                    rgba(255, 255, 255, 0.1),
                    transparent);
            transition: 0.5s;
        }

        .btn-face-login:hover::before {
            left: 100%;
        }

        .form-control {
            border-radius: 8px;
            padding: 0.75rem 1rem;
            border: 1px solid #e0e0e0;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            border-color: #var(--primary);
            box-shadow: 0 0 0 0.2rem rgba(120, 234, 120, 0.3);
        }

        .form-label {
            font-size: 1rem;
            margin-bottom: 0.5rem;
            color: #666;
        }

        .login-title {
            color: #var(--primary);
            font-weight: 600;
        }

        .login-subtitle {
            color: #666;
            font-size: 1.05rem;
        }

        .modal-content {
            border-radius: 15px;
        }

        .modal-header {
            border-radius: 15px 15px 0 0;
            background-color: #var(--primary);
            color: white;
        }

        .modal-title {
            color: white;
        }

        .btn-close {
            filter: brightness(0) invert(1);
        }
    </style>
@endpush

@section('hideSidebar')
@endsection

@section('hideHeader')
@endsection

@section('hideFooter')
@endsection

@section('content')
    <div class="container login-container">
        <div class="card login-card">
            <div class="card-header login-header d-flex align-items-center justify-content-center py-4">
                <img src="{{ asset('general/images/nobg.png') }}" alt="" height="70" class="object-fit-cover">
            </div>
            <div class="card-body p-4">
                <div class="text-center mb-4">
                    <h4 class="login-title mb-2">Chào mừng trở lại!</h4>
                    <p class="login-subtitle mb-0">Vui lòng đăng nhập để tiếp tục</p>
                </div>
                <form action="{{ route('auth.checkLogin') }}" method="post">
                    @csrf
                    <div class="mb-4">
                        <label class="form-label text-sm" for="floatingInput">Tên đăng nhập</label>
                        <input name="username" type="username"
                            class="form-control{{ $errors->has('username') ? ' is-invalid' : '' }}" id="floatingInput"
                            placeholder="Nhập tên đăng nhập của bạn" tabindex="1"
                            value="{{ old('username') }}">
                        @if ($errors->has('username'))
                            <div class="invalid-feedback">
                                {{ $errors->first('username') }}
                            </div>
                        @endif
                    </div>
                    <div class="mb-4">
                        <label class="form-label" for="floatingPassword">Mật khẩu</label>
                        <input name="password" type="password"
                            class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" id="floatingPassword"
                            placeholder="Nhập mật khẩu của bạn" tabindex="2">
                        @if ($errors->has('password'))
                            <div class="invalid-feedback">
                                {{ $errors->first('password') }}
                            </div>
                        @endif
                    </div>
                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary py-2 fw-medium" tabindex="3">
                            <i class="fas fa-sign-in-alt me-2"></i>Đăng nhập
                        </button>
                        {{-- <button type="button" class="btn btn-face-login py-2 fw-medium" data-bs-toggle="modal"
                            data-bs-target="#faceLogin">
                            <i class="fas fa-camera me-2"></i>Đăng nhập bằng khuôn mặt
                        </button> --}}
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Face Login -->
    <div class="modal fade" id="faceLogin" tabindex="-1" aria-labelledby="faceLoginLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="faceLoginLabel">
                        <i class="fas fa-camera me-2"></i>Đăng nhập bằng khuôn mặt
                    </h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-3">
                    <div id="Recognize" class="recognizeface">
                        <div class="wrapper">
                            <video class="w-100 rounded" id="video" autoplay></video>
                        </div>
                        <canvas id="canvas" class="d-none"></canvas>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" id="btnLogin" class="btn btn-primary px-4">
                        <i class="fas fa-sign-in-alt me-2"></i>Đăng nhập
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection
