@extends('layouts.master')

@section('title', 'Huấn luyện')

@push('css')
    <style>
        .wrapper {
            position: relative;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            border-radius: 10px;
            overflow: hidden !important;
        }

        #video {
            transform: scaleX(-1);
            background-color: #ccc;
            border-radius: 10px;
            overflow: hidden;
            position: relative;
        }

        .controls {
            text-align: center;
        }

        .messageInFrame {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(55, 55, 55, 0.5);
            /* Màu nền bán trong suốt */
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            font-weight: bold;
            color: black;
        }

        .fontLarge {
            font-size: 6rem;
        }

        .img-thumbnail {
            height: 100%;
            width: auto;
            object-fit: cover;
        }
    </style>
@endpush

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-6">
            <div class="row mt-3">
                <h4>Hướng dẫn huấn luyện khuôn mặt</h4>
                {{-- <p>Bạn cần nhập username vào ô dữ liệu, sau đó nhấn huấn luyện. Hệ thống sẽ tự động chụp lấy 6 bức
                    ảnh khuôn mặt của bạn và tiến hành nhận diện</p> --}}
                <p>Mỗi một ảnh được chụp sẽ hiển thị bên cạnh khung hình video. Để dữ liệu khuôn mặt có tính xác
                    thực hơn bạn nên chụp các góc mặt như hướng dẫn sau đây:</p>
            </div>
            <div class="row">
                <div id="TrainFace">
                    <div class="wrapper">
                        <video class="w-100" id="video" autoplay class="img-fluid rounded"></video>
                        <div class="messageInFrame text-white d-none">Thông điệp trên khung camera</div>
                    </div>
                    <canvas id="canvas" class="d-none"></canvas>
                </div>
                <div class="controls">
                    <form id="trainForm">
                        <div class="mt-3 mb-2">
                            <select class="form-select" id="employees">
                                
                            </select>
                        </div>
                        <div class="mb-3">
                            {{-- <label for="departments" class="form-label">Phòng ban</label> --}}
                            <select class="form-select" id="departments">
                                @foreach ($departments as $department)
                                    <option value="{{ $department->department_id }}">{{ $department->department_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <button type="submit" id="TrainButton" class="btn btn-outline-secondary">Huấn luyện</button>
                        <div class="message text-danger d-none">Vui lòng nhập Username</div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="row">
                <div class="col-md-6 pb-2">
                    <img id="image1" class="img-thumbnail"
                        src="https://i.pinimg.com/564x/70/89/b2/7089b2489fbc7915346cd60120a25e0a.jpg"
                        alt="Ảnh không tồn tại!">
                </div>
                <div class="col-md-6 pb-2">
                    <img id="image2" class="img-thumbnail"
                        src="https://i.pinimg.com/564x/70/89/b2/7089b2489fbc7915346cd60120a25e0a.jpg"
                        alt="Ảnh không tồn tại!">
                </div>
                <div class="col-md-6 pb-2">
                    <img id="image3" class="img-thumbnail"
                        src="https://i.pinimg.com/564x/70/89/b2/7089b2489fbc7915346cd60120a25e0a.jpg"
                        alt="Ảnh không tồn tại!">
                </div>
                <div class="col-md-6 pb-2">
                    <img id="image4" class="img-thumbnail"
                        src="https://i.pinimg.com/564x/70/89/b2/7089b2489fbc7915346cd60120a25e0a.jpg"
                        alt="Ảnh không tồn tại!">
                </div>
                <div class="col-md-6 pb-2">
                    <img id="image5" class="img-thumbnail"
                        src="https://i.pinimg.com/564x/70/89/b2/7089b2489fbc7915346cd60120a25e0a.jpg"
                        alt="Ảnh không tồn tại!">
                </div>
                <div class="col-md-6 pb-2">
                    <img id="image6" class="img-thumbnail"
                        src="https://i.pinimg.com/564x/70/89/b2/7089b2489fbc7915346cd60120a25e0a.jpg"
                        alt="Ảnh không tồn tại!">
                </div>
                <div class="col-md-6 pb-2">
                    <img id="image7" class="img-thumbnail"
                        src="https://i.pinimg.com/564x/70/89/b2/7089b2489fbc7915346cd60120a25e0a.jpg"
                        alt="Ảnh không tồn tại!">
                </div>
                <div class="col-md-6 pb-2">
                    <img id="image8" class="img-thumbnail"
                        src="https://i.pinimg.com/564x/70/89/b2/7089b2489fbc7915346cd60120a25e0a.jpg"
                        alt="Ảnh không tồn tại!">
                </div>
                <div class="col-md-6 pb-2">
                    <img id="image9" class="img-thumbnail"
                        src="https://i.pinimg.com/564x/70/89/b2/7089b2489fbc7915346cd60120a25e0a.jpg"
                        alt="Ảnh không tồn tại!">
                </div>
                <div class="col-md-6 pb-2">
                    <img id="image10" class="img-thumbnail"
                        src="https://i.pinimg.com/564x/70/89/b2/7089b2489fbc7915346cd60120a25e0a.jpg"
                        alt="Ảnh không tồn tại!">
                </div>
            </div>
        </div>

    </div>
</div>
        
@endsection


@push('javascript')
    <script src="{{ asset('Assets/js/trainface.js') }}"></script>
    <script src="{{ asset('Assets/js/department.js') }}"></script>
@endpush
