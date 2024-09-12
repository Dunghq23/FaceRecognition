<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Document</title>
    <link rel="icon" href="{{ asset('Assets/images/favicon.png') }}" type="image/x-icon" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link
        href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,500&display=swap"
        rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="{{ asset('Assets/css/login.css') }}">

    <style>
        #video {
            transform: scaleX(-1);
            /* Lật theo trục Y */
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="row d-flex align-items-center justify-content-center">
            <div class="col-md-4">
                <div class="card shadow rounded-1">
                    <div class="card-header d-flex align-items-center justify-content-center py-3">
                        <a href="{{ route('home') }}" class="text-center">
                            <img src="{{ asset('images/nobg.png') }}" alt="" height="64"
                                class="object-fit-cover">
                        </a>
                    </div>
                    <div class="card-body p-4">
                        <div class="text-center">
                            <h4 class="text-dark-emphasis text-center pb-0 fs-5 fw-bold">Đăng nhập</h4>
                            <p class="text-muted mb-4">Nhập tên đăng nhập và mật khẩu của bạn</p>
                        </div>
                        <form action="{{ route('checkLogin') }}" method="post">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label fw-medium text-secondary" for="floatingInput">Tên đăng
                                    nhập</label>
                                <input name="username" type="text"
                                    class="form-control{{ $errors->has('username') ? ' is-invalid' : '' }}"
                                    id="floatingInput" placeholder="Vui lòng nhập tên đăng nhập" tabindex="1">
                                <span class="text-danger">
                                    @if ($errors->has('username'))
                                        {{ $errors->first('username') }}
                                    @endif
                                </span>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-medium text-secondary"
                                    for="floatingPassword">Password</label>
                                <input name="password" type="password"
                                    class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}"
                                    id="floatingPassword" placeholder="Vui lòng nhập mật khẩu" tabindex="2">
                                <span class="text-danger">
                                    @if ($errors->has('password'))
                                        {{ $errors->first('password') }}
                                    @endif
                                </span>
                            </div>
                            <div>
                                <button type="submit" class="btn btn-primary rounded-1 w-100 my-2" tabindex="3">Đăng
                                    nhập</button>
                                <button type="button" class="btn btn-success rounded-1 w-100 my-2"
                                    data-bs-toggle="modal" data-bs-target="#faceLogin">
                                    Đăng nhập bằng khuôn mặt
                                </button>
                                <div class="modal fade" id="faceLogin" tabindex="-1" aria-labelledby="faceLoginLabel"
                                    aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h1 class="modal-title fs-5" id="faceLoginLabel">Đăng nhập bằng khuôn
                                                    mặt</h1>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div id="Recognize" class="recognizeface border border-dark">
                                                    <div class="wrapper">
                                                        <video class="w-100" id="video" autoplay></video>
                                                        <div id="loadingIndicator" class="d-none"
                                                            style="text-align: center;">
                                                            <img src="{{ asset('Assets/images/loading.gif') }}"
                                                                alt="Loading..." />
                                                        </div>
                                                    </div>
                                                    <canvas id="canvas" class="d-none"></canvas>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" id="btnLogin" class="btn btn-primary">Đăng
                                                    nhập</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        $(document).ready(function() {
            let stream = null;

            async function startCamera() {
                try {
                    stream = await navigator.mediaDevices.getUserMedia({
                        video: true
                    });
                    const video = $('#video')[0];
                    video.srcObject = stream;
                } catch (error) {
                    console.error('Lỗi khi truy cập camera:', error);
                    Swal.fire({
                        icon: 'error',
                        title: 'Không thể truy cập camera',
                        text: 'Hãy kiểm tra quyền truy cập camera trên trình duyệt của bạn.',
                    });
                }
            }

            function stopCamera() {
                if (stream) {
                    stream.getTracks().forEach(track => track.stop());
                    $('#video')[0].srcObject = null;
                    stream = null;
                }
            }

            $('#faceLogin').on('show.bs.modal', function() {
                startCamera();
                $('#Recognize').removeClass('d-none');
            });

            $('#faceLogin').on('hide.bs.modal', function() {
                stopCamera();
                $('#Recognize').addClass('d-none');
            });

            $('#btnLogin').on('click', function() {
                takePhoto();
            });

            function takePhoto() {
                const video = $('#video')[0];
                const canvas = $('#canvas')[0];
                const context = canvas.getContext('2d');

                canvas.width = video.videoWidth;
                canvas.height = video.videoHeight;

                context.drawImage(video, 0, 0, canvas.width, canvas.height);
                const imageBase64 = canvas.toDataURL('image/png');
                $('#loadingIndicator').removeClass('d-none');

                $.ajax({
                    url: '/save-photo',
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                        'Content-Type': 'application/json'
                    },
                    data: JSON.stringify({
                        imageBase64
                    }),
                    success: function(response) {
                        console.log('Ảnh đã được lưu:', response.filepath);
                        recognizeFace(response.filepath);
                    },
                    error: function(xhr, status, error) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Lỗi',
                            text: 'Đã có lỗi xảy ra khi gửi ảnh tới máy chủ!',
                        });
                        console.error('Lỗi:', error);
                    }
                });
            }

            function recognizeFace(imagePath) {
                $.ajax({
                    url: '/recognize-face',
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                        'Content-Type': 'application/json'
                    },
                    data: JSON.stringify({
                        imagePath
                    }),
                    success: function(response) {
                        let name = response.recognizedName;
                        console.log('Tên người được nhận dạng:', name);

                        if (name !== 'Unknown' && name !== 'Không có khuôn mặt được tìm thấy!' &&
                            name != 'Phát hiện 2 khuôn mặt, vui lòng thử lại!') {
                            Swal.fire({
                                title: 'Nhận diện thành công',
                                text: `Chào mừng ${name}!`,
                                icon: 'success'
                            });
                        } else {
                            Swal.fire({
                                title: 'Cảnh báo!',
                                text: 'Nhân viên này không tồn tại!',
                                icon: 'warning'
                            });
                        }
                    },
                    error: function(xhr, status, error) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Lỗi',
                            text: 'Đã có lỗi xảy ra khi nhận diện ảnh!',
                        });
                        console.error('Lỗi:', error);
                    },
                    complete: function() {
                        $('#loadingIndicator').addClass('d-none');
                    }
                });
            }
        });
    </script>
</body>

</html>
