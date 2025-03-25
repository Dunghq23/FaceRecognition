$(document).ready(function () {
    $("#keySearch").on('input', function () {
        let searchValue = $(this).val();
        const urlParams = new URLSearchParams(window.location.search);
        const page = urlParams.get('page');
        $('.card-footer').hide();
        $.ajax({
            url: "/management/systemLogs/searchLogs",
            type: "POST",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {
                searchValue: searchValue,
                page: page
            },
            success: function (response) {
                let table = $("#table-data");
                table.html('');
                let html = '';

                if(Array.isArray(response)) {
                    response.forEach((each) => {
                        html += `<tr class="align-middle">
                                <th scope="row" class="text-center text-body-secondary">
                                    ${each.log_id}
                                </th>
                                <td>${each.username}</td>
                                <td>${each.employee_name}</td>
                                <td class="text-center">${each.action}</td>
                                <td class="text-center">${each.time}</td>
                            </tr>`;
                    });
                } 
                else {
                    Object.values(response).forEach((each) => {
                        html += `<tr class="align-middle">
                                <th scope="row" class="text-center text-body-secondary">
                                    ${each.log_id}
                                </th>
                                <td>${each.username}</td>
                                <td>${each.employee_name}</td>
                                <td class="text-center">${each.action}</td>
                                <td class="text-center">${each.time}</td>
                            </tr>`;
                    });
                }
                
                table.append(html);
                $('.card-footer').show();
            },
            error: function (xhr) {
                // Xử lý lỗi khi gửi yêu cầu Ajax
                console.log(xhr.responseText);
                alert("Có lỗi xảy ra. Vui lòng thử lại sau.");
            },
        });
    });

    $('#select-account').on('change', function () {
        let account = $(this).val();
        const urlParams = new URLSearchParams(window.location.search);
        const page = urlParams.get('page');
        $('.card-footer').hide();
        $.ajax({
            url: "/management/systemLogs/filterLogs",
            type: "POST",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {
                account_id: account,
                page: page
            },
            success: function (response) {
                let table = $("#table-data");
                table.html('');
                let html = '';
                // console.log(response);

                response.forEach((each) => {
                    html += `<tr class="align-middle">
                            <th scope="row" class="text-center text-body-secondary">
                                ${each.log_id}
                            </th>
                            <td>${each.username}</td>
                            <td>${each.employee_name}</td>
                            <td class="text-center">${each.action}</td>
                            <td class="text-center">${each.time}</td>
                        </tr>`;
                });
                table.append(html);

                if(account == 0) {
                    $('.card-footer').show();
                }
            },
            error: function (xhr) {
                // Xử lý lỗi khi gửi yêu cầu Ajax
                console.log(xhr.responseText);
                alert("Có lỗi xảy ra. Vui lòng thử lại sau.");
            },
        });
    });
});