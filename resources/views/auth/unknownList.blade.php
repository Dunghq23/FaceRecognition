@extends('layouts.master')

@section('title', 'Danh sách khuôn mặt chưa biết')

@section('content')
    <div class="container">
        <div class="card mt-3">
            <div class="card-header">
                <h2>Danh sách khuôn mặt chưa biết</h2>
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <thead class="thead-dark">
                        <tr class="text-center">
                            <th scope="col">STT</th>
                            <th scope="col">Hình ảnh</th>
                            <th scope="col">Ngày nhận diện</th>
                            <th scope="col">Huấn luyện</th>
                            <th scope="col">Xóa</th>
                        </tr>
                    </thead>
                    <tbody class="text-center align-middle">
                        @foreach ($unknownRecognitions as $recognition)
                            <tr>
                                <td>{{ $recognition['id'] }}</td>
                                <td><img src="{{ $recognition['image'] }}" class="img-thumbnail" alt="Image"
                                        style="max-width: 100px;"></td>
                                <td>{{ $recognition['date'] }}</td>
                                <td>
                                    <button type="button" class="btn btn-primary btn-train"
                                        data-file="{{ $recognition['image'] }}" data-bs-toggle="modal"
                                        data-bs-target="#trainModal">
                                        Huấn luyện
                                    </button>
                                </td>
                                <td>
                                    <button class="btn btn-danger btn-delete" data-file="{{ $recognition['image'] }}">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Thêm modal này vào sau phần table -->
    <div class="modal fade" id="trainModal" tabindex="-1" aria-labelledby="trainModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="trainModalLabel">Huấn luyện khuôn mặt</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="trainForm">
                        <label for="departments" class="form-label">Nhân viên</label>
                        <div class="mb-2">
                            <select class="form-select" id="employees">
                                
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="departments" class="form-label">Phòng ban</label>
                            <select class="form-select" id="departments">
                                @foreach ($departments as $department)
                                    <option value="{{ $department->department_id }}">{{ $department->department_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <input type="hidden" id="recognitionId" name="recognitionId">
                        <button type="submit" id="submit" class="btn btn-primary">Lưu</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div id="cover-spin"></div>

@endsection

@push('javascript')
    <script src="{{asset('Assets/js/department.js')}}"></script>
    <script src="{{asset('Assets/js/trainUnknown.js')}}"></script>
@endpush
