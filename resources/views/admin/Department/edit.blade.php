@extends('layouts.master')

@section('title', 'Chỉnh sửa phòng ban')

@push('css')

@endpush

@section('content')
<div class="container mt-5">
    <h2>Chỉnh sửa Phòng Ban</h2>

    <!-- Hiển thị thông báo thành công nếu có -->
    @if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif

    <!-- Form chỉnh sửa phòng ban -->
    <form action="{{ route('admin.department.update', $department->department_id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="department_name" class="form-label">Tên Phòng Ban</label>
            <input type="text" class="form-control @error('department_name') is-invalid @enderror" id="department_name" name="department_name" value="{{ old('department_name', $department->department_name) }}" required>
            @error('department_name')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary">Cập nhật</button>
        <a href="{{ route('admin.department.index') }}" class="btn btn-secondary">Quay lại</a>
    </form>

</div>
@endsection

@push('javascript')

@endpush