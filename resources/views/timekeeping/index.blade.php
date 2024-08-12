@extends('layouts.master')

@section('title', 'Chấm công')

@push('css')
    <link rel="stylesheet" href="{{ asset('Assets/css/login.css') }}">
@endpush

@section('content')
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div id="Recognize" class="recognizeface border border-dark">
                    <div class="wrapper">
                        <video class="w-100" id="video" autoplay class="img-fluid rounded"></video>
                        <div id="loadingIndicator" class="d-none" style="text-align: center;">
                            <img src="{{ asset('Assets/images/loading.gif') }}" alt="Loading..." />
                        </div>
                    </div>
                    {{-- <div class="controls">
                        <button id="timekeeping_btn" class="btn btn-success align-middle">Chấm công</button>
                        <button id="toggle-camera" class="btn btn-danger"><i class="fa-solid fa-camera"></i></button>
                        <h1 id="personName" class="d-none"></h1>
                    </div> --}}
                    <div class="align-middle p-2 text-center">
                        <button type="button" id="timekeeping_btn" class="btn btn-primary">Chấm công</button>
                        <h1 id="personName" class="d-none"></h1>
                    </div>
                    <canvas id="canvas" class="d-none"></canvas>
                </div>
            </div>

            <div class="col-md-6">
                <img src="https://www.phucanh.vn/media/news/1809_BVmaychamcongnhandienkhuonmatuudiem.jpg"
                    id="recognizedImage" class="w-100" alt="Recognized Image" />
            </div>
        </div>
    </div>
@endsection

@push('javascript')
    <script>
        $(document).ready(function() {
            var filePath;
            var recogName;

            // Hàm bắt đầu camera
            async function startCamera() {
                try {
                    let stream = await navigator.mediaDevices.getUserMedia({
                        video: true
                    });
                    const video = $('#video')[0];
                    video.srcObject = stream;
                } catch (error) {
                    console.error('Lỗi khi truy cập camera:', error);
                }
            }

            startCamera();

            // Hàm dừng camera
            function stopCamera() {
                if (stream) {
                    stream.getTracks().forEach(track => track.stop());
                    const video = $('#video')[0];
                    video.srcObject = null;
                    stream = null;
                }
            }

            // Xử lý sự kiện click vào nút "Đăng nhập bằng khuôn mặt"
            // $('#toggle-camera').click(function() {
            //     $('#Recognize').toggle(); // Hiển thị hoặc ẩn phần nhận dạng khuôn mặt
            //     if (stream) {
            //         stopCamera();
            //         $('#Recognize').addClass('d-none');
            //     } else {
            //         startCamera();
            //         $('#Recognize').removeClass('d-none');
            //     }
            // });

            function ShowToast(message) {
                const Toast = Swal.mixin({
                    toast: true,
                    position: "top-end",
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                    didOpen: (toast) => {
                        toast.onmouseenter = Swal.stopTimer;
                        toast.onmouseleave = Swal.resumeTimer;
                    }
                });
                Toast.fire({
                    icon: "error",
                    title: message
                });
            }

            // Xử lý sự kiện click vào nút "Nhận dạng"
            $('#timekeeping_btn').click(function() {
                takephoto();
            });

            function takephoto() {
                // Lấy video và canvas elements
                const video = $('#video')[0];
                const canvas = $('#canvas')[0];
                const context = canvas.getContext('2d');

                // Đặt kích thước canvas bằng với kích thước video
                canvas.width = video.videoWidth;
                canvas.height = video.videoHeight;

                // Đảo ngược hình ảnh nếu cần thiết
                context.translate(canvas.width, 0);
                context.scale(-1, 1);

                // Vẽ khung hình hiện tại của video lên canvas
                context.drawImage(video, 0, 0, canvas.width, canvas.height);

                // Lấy dữ liệu ảnh từ canvas dưới dạng base64
                const imageBase64 = canvas.toDataURL('image/png');
                $('#loadingIndicator').removeClass('d-none');
                // $('#personName').addClass('d-none');
                // Gửi dữ liệu ảnh base64 đến máy chủ qua AJAX
                $.ajax({
                    url: '/save-photo',
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                        'Content-Type': 'application/json'
                    },
                    data: JSON.stringify({
                        imageBase64: imageBase64
                    }),
                    success: function(response) {
                        console.log('Ảnh đã được lưu:', response.filepath);
                        filePath = response.filepath;
                        recognizeFace(response.filepath);
                    },
                    error: function(xhr, status, error) {
                        ShowToast("Đã có lỗi xảy ra khi gửi ảnh tới máy chủ!");
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
                        imagePath: imagePath
                    }),
                    success: function(response) {
                        let name = response.recognizedName;
                        console.log('Tên người được nhận dạng:', name);
                        // $('#personName').text(name);

                        if (name !== 'Unknown' && name !== 'Không có khuôn mặt được tìm thấy!' &&
                            name != 'Phát hiện 2 khuôn mặt, vui lòng thử lại!') {
                            TimeKeeping(name);
                            recogName = name;
                        } else {
                            Swal.fire({
                                title: "Cảnh báo!",
                                text: 'Nhân viên này không tồn tại!',
                                icon: "warning"
                            });
                        }

                    },
                    error: function(xhr, status, error) {
                        ShowToast("Đã có lỗi xảy ra khi nhận diện ảnh!");
                        console.error('Lỗi:', error);
                    },
                    complete: function() {
                        $('#loadingIndicator').addClass('d-none');
                        recogName = recogName ? recogName + '.jpg' : 'Unknown.jpg';
                        let newFilePath = filePath.replace('.png', recogName);
                        console.log(newFilePath);
                        $('#recognizedImage').attr('src', newFilePath);
                        recogName = undefined;
                    }
                });
            }

            // timekeeping
            function TimeKeeping(employee_name) {
                $.ajax({
                    url: '/timekeeping',
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    },
                    data: {
                        employee_name: employee_name
                    },
                    success: function(response) {
                        let status = response['status'];
                        let message = response['message'];
                        if (status === 'error') {
                            Swal.fire({
                                title: "Lỗi!",
                                text: employee_name + " " + message,
                                icon: "error"
                            });
                        } else {
                            Swal.fire({
                                title: "Thành công!",
                                text: message,
                                icon: "success"
                            });
                        }
                    },
                    error: function(xhr, status, error) {
                        ShowToast("Đã có lỗi xảy ra khi chấm công!");
                        console.error('Lỗi:', error);
                    },
                });
            }
        });
    </script>
@endpush
