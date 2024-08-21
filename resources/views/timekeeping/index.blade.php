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
    <script src="{{asset('Assets/js/timekeeping.js')}}"></script>
@endpush
