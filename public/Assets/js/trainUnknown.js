$(document).ready(function() {

    function ShowToast(message, type) {
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
            icon: type,
            title: message
        });
    }

    var filePath;
    var rowDelete;
    $('.btn-delete').click(function(e) {
        e.preventDefault();
        filePath = $(this).data('file');
        rowDelete = $(this).closest('tr');
        $('#cover-spin').show(0);
        $.ajax({
            url: "/delete-image",
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            },
            data: {
                filePath: filePath // Chắc chắn rằng đường dẫn được gửi đi đúng định dạng
            },
            success: function(response) {
                if (response.success) {
                    setTimeout(function() {
                        rowDelete.remove();
                        $('#cover-spin').hide(0);
                        ShowToast(response['success'], "success");
                    }, 1000);
                } else {
                    console.error(response.error);
                }
            },
            error: function(xhr, status, error) {
                ShowToast("Đã có lỗi xảy ra!", "error");
            }
        });
    });


    // Xử lý sự kiện huấn luyện
    $('.btn-train').click(function() {
        var recognitionId = $(this).closest('tr').find('td:first').text();
        $('#recognitionId').val(recognitionId);
        filePath = $(this).data('file');
        rowDelete = $(this).closest('tr');
    });

    // Xử lý sự kiện huấn luyện
    $('#trainForm').submit(function(e) {
        e.preventDefault();
        let employee_id = $('#employees').val();

        if(!employee_id){
            ShowToast("Vui lòng chọn nhân viên phù hợp!", "error");
            return;
        }
        $('#cover-spin').show(0);
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
                $('#trainModal').modal('hide');
                setTimeout(function() {
                    rowDelete.remove();
                    $('#cover-spin').hide(0);
                    ShowToast(response['message'], response['status']);
                }, 1500);
            },
            error: function(error) {
                ShowToast("Đã có lỗi xảy ra!", "error");
            }
        });
    });
});