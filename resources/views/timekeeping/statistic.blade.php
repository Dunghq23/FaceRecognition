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
    <script src="{{asset('Assets/js/statistic.js')}}"></script>
@endpush
