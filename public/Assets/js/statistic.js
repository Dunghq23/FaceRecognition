$(document).ready(function() {
    $('#timeStart').timepicker({
        uiLibrary: 'bootstrap5'
    });
    $('#timeEnd').timepicker({
        uiLibrary: 'bootstrap5'
    });
    $('#datePicker').datepicker({
        uiLibrary: 'bootstrap5',
        format: 'dd/mm/yyyy'
    });

    // set current 
    function SetCurrentDate() {
        let today = new Date();

        // Format the date as MM/DD/YYYY
        let formattedDate = today.getDate().toString().padStart(2, '0') + '/' +
            (today.getMonth() + 1).toString().padStart(2, '0') + '/' +
            today.getFullYear();

        // Set the value of the input field
        $('#datePicker').val(formattedDate);
    }

    SetCurrentDate();

    // show notification
    function ShowToast(message, status) {
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
            icon: status,
            title: message
        });
    }

    // call ajax
    function Statistics() {
        $('#cover-spin').show(0);
        let timeStart = $('#timeStart').val();
        let timeEnd = $('#timeEnd').val();
        let datePicker = $('#datePicker').val();
        $.ajax({
            url: '/statistics',
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {
                timeStart: timeStart,
                timeEnd: timeEnd,
                datePicker: datePicker,
            },
            success: function(response) {
                // console.log(response['employees']);

                let today = new Date();
                let formattedDate = (today.getMonth() + 1).toString().padStart(2, '0') + '/' +
                    today.getFullYear();

                let employees = response['employees'];
                let tableBody = $('#employeesTableBody');
                tableBody.empty();
                let i = 1;
                employees.forEach(employee => {
                    let earlyMinutes = employee['early'];
                    let latelyMinutes = employee['lately'];

                    let cellEarly = earlyMinutes != null ? `<td class="text-danger">${employee['check_out'] + ` (Sớm ${earlyMinutes} phút)`}</td>` : `<td>${employee['check_out']}</td>`;
                    let cellLately = latelyMinutes != null ? `<td class="text-danger">${employee['check_in'] + ` (Muộn ${latelyMinutes} phút)`}</td>` : `<td>${employee['check_in']}</td>`;

                    let row = `<tr>
                                    <td>${i++}</td>
                                    <td>${employee['employee_name']}</td>
                                    <td>${employee['department']['department_name']}</td>
                                    ${cellLately}
                                    ${cellEarly}
                                    <td>
                                        <button type="button" data-bs-toggle="modal" data-employee-id='${employee['employee_id']}' class="btn btn-outline-primary btn-detail">
                                            <i class="fa fa-eye"></i>
                                        </button>
                                        <div class="modal fade" id="detail${employee['employee_id']}" tabindex="-1" aria-hidden="true">
                                            <div class="modal-dialog modal-fullscreen">
                                                <div class="modal-content">
                                                    <div class="modal-header d-flex justify-content-center align-items-center">
                                                        <h1 class="modal-title fs-4">THỐNG KÊ CHI TIẾT</h1>
                                                    </div>
                                                    <div class="modal-body">
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    </tr>`;
                    tableBody.append(row);

                    let myModal = $('#detail'+employee['employee_id']);
                    let modalBody = $(myModal).find('.modal-body');
                    modalBody.empty();

                    let html = `<div class="row">
                                    <div class="card border border-dark-subtle">
                                        <div class="card-header bg-transparent">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="mb-2 mt-2 text-primary fw-semibold text-start">Nhân viên: <input type="text" class="employee border-0" value="${employee['employee_name']}" readonly></div>
                                                    <div class="mb-2 text-primary fw-semibold text-start">Phòng ban: <input type="text" class="department border-0" value="${employee['department']['department_name']}" readonly></div>
                                                </div>
                                                <div class="col-md-6 d-flex align-items-center justify-content-end">
                                                    <div class="w-50">
                                                        <input class="form-control border border-dark-subtle align-middle p-2 dateDetail" type="month" id="dateView${employee['employee_id']}" data-employee-id='${employee['employee_id']}' min="2024-01" value="2024-08" placeholder="Tháng làm việc" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <table class="table table-bordered">
                                                <thead class="thead-dark">
                                                    <tr class="text-center">
                                                        <th scope="col" class="bg-primary text-white">Ngày</th>
                                                        <th scope="col" class="bg-primary text-white">Vào</th>
                                                        <th scope="col" class="bg-primary text-white">Ra</th>
                                                        <th scope="col" class="bg-primary text-white">Trễ</th>
                                                        <th scope="col" class="bg-primary text-white">Sớm</th>
                                                        <th scope="col" class="bg-primary text-white">Công</th>
                                                        <th scope="col" class="bg-primary text-white">Tổng giờ</th>
                                                    </tr>
                                                </thead>
                                                <tbody class="text-center align-middle" id="tbbody_detail${employee['employee_id']}"></tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>`;
                            
                    modalBody.append(html);
                });
                $('#cover-spin').hide(0);                   
            },
            error: function(xhr, status, error) {
                ShowToast("Đã có lỗi xảy ra khi thực hiện thống kê!", "error");
                // console.error('Lỗi:', error);
            }
        });
    }

    function ShowDetailStatistic(employee_id, timeStart, timeEnd, dateView) {
        $('#cover-spin').show(0);
        $.ajax({
            url: '/statisticsByEmployee',
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {
                employee_id: employee_id,
                time_start: timeStart,
                time_end: timeEnd,
                dateView: dateView,
            },
            success: function(response) {
                // console.log(response['data']);
                let employee = response['data'];
                renderHtmlModal(employee);
                $('#cover-spin').hide(0);
            },
            error: function(xhr, status, error) {
                ShowToast("Đã có lỗi xảy ra khi xem chi tiết thống kê!", "error");
            }
        });
    } 

    function renderHtmlModal(employee)
    {
        let myModal = $('#detail'+employee['employee_id']);

        let tbbody = $('#tbbody_detail' + employee['employee_id']);
        tbbody.empty();
        employee['timekeepings'].forEach(item => {
            let row = `<tr>
                        <td>${item['day']}</td>
                        <td>${item['check_in']}</td>
                        <td>${item['check_out']}</td>
                        <td>${item['lately']}</td>
                        <td>${item['early']}</td>
                        <td>${item['labour']}</td>
                        <td>${item['totalHours']}</td>
                    </tr>`;
            tbbody.append(row);
        });

        myModal.modal('show');
    }

    // call func
    $('#btn-statistics').on('click', function() {
        Statistics();
    })

    $('#btn-statistics').trigger('click');

    $(document).on('click', '.btn-detail', function() {
        let employee_id = $(this).data('employee-id');
        let timeStart = $('#timeStart').val();
        let timeEnd = $('#timeEnd').val();
        let dateView = $('#dateView'+employee_id).val();
        ShowDetailStatistic(employee_id, timeStart, timeEnd, dateView);
    });

    $(document).on('change', '.dateDetail', function() {
        let employee_id = $(this).data('employee-id');
        let timeStart = $('#timeStart').val();
        let timeEnd = $('#timeEnd').val();
        let dateView = $(this).val();
        ShowDetailStatistic(employee_id, timeStart, timeEnd, dateView);
    });
});