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
        let employee_id = $('#employees').val();

        if(!employee_id){
            ShowToast("Vui lòng chọn nhân viên phù hợp!", "error");
            return;
        }

        $.ajax({
            url: '/photo-train-image', // Đường dẫn xử lý huấn luyện
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            },
            data: {
                employee_id: employee_id,
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