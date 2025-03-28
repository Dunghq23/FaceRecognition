$(document).ready(function () {
    // get data
    function GetEmployeesByDepartment(department_id) {
        $.ajax({
            url: '/management/getEmployeesByDepartment',
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
                ShowToast('error', 'Đã có lỗi xảy ra!');
            },
        });
    }

    $('#departments').on('change', function(){
        let department_id = $(this).val();
        if(department_id === "") {
            return;
        }
        GetEmployeesByDepartment(department_id);
    })

    $('#departments').trigger('change');
});