@extends('layouts.master')

@section('title', 'Thống kê')

@push('css')
    <style>
        .gj-datepicker {
            margin: 0 !important;
        }

        .employee:focus,
        .department:focus {
            border: none;
            box-shadow: none;
            outline: none;
        }

        .dateDetail:focus {
            box-shadow: none;
            outline: none;
        }
    </style>
@endpush

@section('content')
    <div class="row">
        <div class="card border border-dark-subtle">
            <div class="card-header bg-transparent">
                <form class="row align-items-center justify-content-end">
                    <div class="col-sm-2">
                        {{-- <label class="visually" for="datePicker">Ngày thống kê</label> --}}
                        <input class="form-control border border-dark-subtle align-middle p-2" id="datePicker"
                            placeholder="Ngày làm việc" readonly />
                    </div>
                    <div class="col-sm-2">
                        {{-- <label class="visually" for="timeStart">Giờ bắt đầu</label> --}}
                        <input class="form-control border border-dark-subtle align-middle p-2" id="timeStart"
                            placeholder="Giờ bắt đầu" value="8:15" readonly />
                    </div>
                    <div class="col-sm-2">
                        {{-- <label class="visually" for="timeEnd">Giờ kết thúc</label> --}}
                        <input class="form-control border border-dark-subtle align-middle p-2" id="timeEnd"
                            placeholder="Giờ kết thúc" value="17:15" readonly />
                    </div>
                    <div class="col-sm-1">
                        <button type="button" class="btn btn-primary" id="btn-statistics" style="font-size: 12px">Thống
                            kê</button>
                    </div>
                </form>
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <thead class="thead-dark">
                        <tr class="text-center">
                            <th scope="col">STT</th>
                            <th scope="col">Tên</th>
                            <th scope="col">Phòng ban</th>
                            <th scope="col">Vào ca</th>
                            <th scope="col">Ra ca</th>
                            <th scope="col">Chi tiết</th>
                        </tr>
                    </thead>
                    <tbody class="text-center align-middle" id="employeesTableBody">
                    </tbody>
                </table>
                <div id="cover-spin"></div>
            </div>
        </div>
    </div>
@endsection

@push('javascript')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>
    <script src="{{ asset('Assets/js/statistic.js') }}"></script>
    <script>
        $(document).ready(function() {
            $(document).on("click", ".btnExport", async function() {
                let id = $(this).data("value");
                let employeeName = $("#employeeName" + id).val();
                let department = $("#department" + id).val();

                var table = document.getElementById("tableExport" + id);
                var rows = table.getElementsByTagName("tr");
                var data = [];

                data.push(["Tên nhân viên:", employeeName]);
                data.push(["Phòng ban:", department]);
                data.push([]);

                let headers = [];
                let headerRow = rows[0];
                let headerCells = headerRow.getElementsByTagName("th");
                for (let j = 0; j < headerCells.length; j++) {
                    headers.push(headerCells[j].innerText.trim());
                }
                data.push(headers);

                for (let i = 1; i < rows.length; i++) {
                    let row = rows[i];
                    let cells = row.getElementsByTagName("td");
                    let rowData = [];
                    for (let j = 0; j < cells.length; j++) {
                        let cellValue = cells[j].innerText.trim();
                        let dateMatch = cellValue.match(/^(\d{2})\/(\d{2})\/(\d{4})$/);
                        if (dateMatch) {
                            rowData.push(`${dateMatch[1]}/${dateMatch[2]}/${dateMatch[3]}`);
                        } else {
                            rowData.push(cellValue);
                        }
                    }
                    data.push(rowData);
                }

                var wb = XLSX.utils.book_new();
                var ws = XLSX.utils.aoa_to_sheet(data);

                ws['!rows'] = [{
                    hpt: 24
                }];
                ws['!cols'] = [{
                    wpx: 100
                }, {
                    wpx: 150
                }, {
                    wpx: 100
                }, {
                    wpx: 150
                }];

                var headerStyle = {
                    fill: {
                        fgColor: {
                            rgb: "FFFF00"
                        }
                    },
                    font: {
                        sz: 14,
                        bold: true,
                        color: {
                            rgb: "000000"
                        }
                    }
                };

                var range = XLSX.utils.decode_range(ws['!ref']);
                for (let col = range.s.c; col <= range.e.c; col++) {
                    let cell_address = XLSX.utils.encode_cell({
                        r: 0,
                        c: col
                    });
                    if (!ws[cell_address]) ws[cell_address] = {};
                    ws[cell_address].s = headerStyle;
                }

                XLSX.utils.book_append_sheet(wb, ws, "Sheet1");

                var wbout = XLSX.write(wb, {
                    bookType: 'xlsx',
                    type: 'array'
                });
                var blob = new Blob([wbout], {
                    type: 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
                });

                try {
                    // Sử dụng showSaveFilePicker để cho phép người dùng chọn nơi lưu file
                    const handle = await window.showSaveFilePicker({
                        suggestedName: 'exported_file.xlsx',
                        types: [{
                            description: 'Excel Files',
                            accept: {
                                'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet': [
                                    '.xlsx'
                                ]
                            }
                        }]
                    });

                    const writableStream = await handle.createWritable();
                    await writableStream.write(blob);
                    await writableStream.close();
                } catch (error) {
                    console.error("Error saving file:", error);
                }
            });
        });
    </script>
@endpush
