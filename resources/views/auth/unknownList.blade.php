@extends('layouts.main')

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
                        <div class="mb-3">
                            <label for="employee_name" class="form-label">Tên nhân viên</label>
                            <input type="text" class="form-control" id="employee_name" name="employee_name" required
                                minlength="6" maxlength="30" pattern="[a-zA-ZÀ-ỹ]+"
                                title="Họ tên vui lòng không chứa ký tự dấu cách và chỉ chứa chữ cái!">
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

@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            var filePath;
            $('.btn-delete').click(function(e) {
                e.preventDefault();
                filePath = $(this).data('file');
                var token = "{{ csrf_token() }}";

                $.ajax({
                    url: "{{ route('delete.image') }}",
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        _token: token,
                        filePath: filePath // Chắc chắn rằng đường dẫn được gửi đi đúng định dạng
                    },
                    success: function(response) {
                        if (response.success) {
                            // Tải lại danh sách sau khi xóa thành công
                            location.reload();
                        } else {
                            console.error(response.error);
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error(xhr.responseText);
                        // Xử lý lỗi
                    }
                });
            });


            // Xử lý sự kiện huấn luyện
            $('.btn-train').click(function() {
                var recognitionId = $(this).closest('tr').find('td:first').text();
                $('#recognitionId').val(recognitionId);
                filePath = $(this).data('file');
            });

            // Xử lý sự kiện huấn luyện
            $('#trainForm').submit(function(e) {
                e.preventDefault();
                let employee_name = $('#employee_name').val();
                let deparment_id = $('#departments').val();

                $.ajax({
                    url: '/photo-train-image', // Đường dẫn xử lý huấn luyện
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    },
                    data: {
                        employee_name: employee_name,
                        deparment_id: deparment_id,
                        filePath: filePath
                    },
                    success: function(response) {
                        // console.log(response);
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

                        if (response['status'] == 'success') {
                            Toast.fire({
                                icon: "success",
                                title: response['message']
                            });
                        } else {
                            Toast.fire({
                                icon: "error",
                                title: response['message']
                            });
                        }

                        $('#trainModal').modal('hide');
                        // location.reload();
                    },
                    error: function(error) {
                        console.error('Lỗi:', error);
                    }
                });
            });
        });
    </script>
@endpush
