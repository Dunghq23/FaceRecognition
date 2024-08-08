@extends('layouts.master')

@section('title', 'Thống kê chi tiết')

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
    </style>
@endpush

@section('content')
    <div class="row">
        <div class="card border border-dark-subtle">
            <div class="card-header bg-transparent">
                <div class="row">
                    <h4 class="text-center mt-3 mb-3">CHI TIẾT CHẤM CÔNG</h4>
                    <hr>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-2 text-primary fw-semibold">Nhân viên: <input type="text" class="employee border-0" value="Đỗ Hữu Tuấn" readonly></div>
                        <div class="mb-2 text-primary fw-semibold">Phòng ban: <input type="text" class="department border-0" value="Công nghệ thông tin" readonly></div>
                    </div>
                    <div class="col-md-6 d-flex align-items-center justify-content-end">
                        <div class="w-50">
                            <input class="form-control border border-dark-subtle align-middle p-2" id="dateView"
                            placeholder="Tháng làm việc" readonly />
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
                    <tbody class="text-center align-middle" id="tbbody_detail">
                        @for ($i = 0; $i < 30; $i++)
                            <tr>
                                <td>07/08/2024</td>
                                <td>1</td>
                                <td>1</td>
                                <td>1</td>
                                <td>1</td>
                                <td>1</td>
                                <td>1</td>
                            </tr>
                        @endfor
                    </tbody>
                </table>
                <div id="cover-spin"></div>
            </div>
        </div>
    </div>
@endsection

@push('javascript')
    <script>
        $(document).ready(function() {
            $('#dateView').datepicker({
                uiLibrary: 'bootstrap5'
            });
        });
    </script>
@endpush
