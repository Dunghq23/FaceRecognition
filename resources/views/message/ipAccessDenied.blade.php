@extends('layouts.master')

@section('title', 'Lỗi truy cập')

@push('css')
    <!-- Thêm các CSS tùy chỉnh nếu cần -->
@endpush

@section('content')
    <div class="container mt-5">
        <h1>Truy cập bị từ chối</h1>
        <h3>Vui lòng truy cập mạng của công ty để thực hiện chấm công</h3>
        {{-- <pre>{{ $responseMessage }}</pre> <!-- Hiển thị thông tin lỗi --> --}}
    </div>
@endsection

@push('javascript')
    <!-- Thêm các JavaScript tùy chỉnh nếu cần -->
@endpush
