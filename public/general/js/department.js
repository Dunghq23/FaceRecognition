$(document).ready(function () {
    // toast
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

    // get data
    function GetEmployeesByDepartment(department_id) {
        $.ajax({
            url: 'admin/getEmployeesByDepartment',
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            },
            data: {
                department_id: department_id
            },
            success: function(response) {
                let employees = response['employees'];
                console.log(response['employees']);
                let select_employee = $('#employees');
                select_employee.empty();

                employees.forEach(employee => {
                    let option = `<option value="${employee['employee_id']}">${employee['employee_name']}</option>`;
                    select_employee.append(option);
                });
                
            },
            error: function(xhr, status, error) {
                ShowToast("Đã có lỗi xảy ra khi xem nhân viên theo phòng ban!");
            },
        });
    }

    $('#departments').on('change', function(){
        let department_id = $(this).val();
        GetEmployeesByDepartment(department_id);
    })

    $('#departments').trigger('change');
});