@extends('layouts.master')

@section('title', 'Tin tuyển dụng - Thêm mới')

@push('css')
    <style>
        label {
            font-weight: 600;
            font-size: 14px;
        }

        .form-control,
        .form-select {
            font-size: smaller;
        }

        .scrollable-row {
            max-height: 600px;
            overflow-y: auto;
        }
    </style>
@endpush

@section('content')
    <div class="row g-0 p-3">
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item fw-medium"><a class="text-decoration-none" href="{{ route('home') }}">Trang chủ</a>
            </li>
            <li class="breadcrumb-item fw-medium"><a class="text-decoration-none" href="{{ route('recruit.jobs.index') }}">Tin
                    tuyển dụng</a>
            </li>
            <li class="breadcrumb-item active fw-medium" aria-current="page">
                Thêm mới
            </li>
        </ol>
    </div>
    <x-dashboard-title text="Thêm mới tin tuyển dụng" />
    <div class="row g-0 p-3">
        <div class="col-lg-9 p-3">
            <form id="form_jobPost" action="{{ route('recruit.jobs.store') }}" method="POST">
                @csrf
                <div class="row overflow-y-scroll scrollable-row">
                    <div class="col-md-12 mb-4 p-4 bg-white rounded">
                        <div class="row mb-2">
                            <h6 class="fw-bold">THÔNG TIN CHUNG</h6>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="title">Tiêu đề <span class="text-danger">*</span></label>
                                    <input type="text" id="title" name="title" class="form-control"
                                        placeholder="Tiêu đề tin đăng" required>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="departments">Phòng ban <span class="text-danger">*</span></label>
                                    <select id="departments" name="department_id" class="form-select" required>
                                        <option value="">Chọn phòng ban</option>
                                        @foreach ($departments as $deparment)
                                            <option value="{{ $deparment->department_id }}">
                                                {{ $deparment->department_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="fk_level_id">Cấp bậc <span class="text-danger">*</span></label>
                                    <select id="fk_level_id" name="fk_level_id" class="form-select">
                                        <option value="">Chọn cấp bậc</option>
                                        @foreach ($levels as $level)
                                            <option value="{{ $level->level_id }}">{{ $level->level_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="role_hire">Vị trí tuyển dụng <span class="text-danger">*</span></label>
                                    <input type="text" id="role_hire" name="role_hire" class="form-control"
                                        placeholder="Vị trí tuyển dụng" required>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="fk_major_id">Ngành nghề <span class="text-danger">*</span></label>
                                    <select id="fk_major_id" name="fk_major_id" class="form-select" required>
                                        <option value="">Chọn ngành nghề</option>
                                        @foreach ($majors as $major)
                                            <option value="{{ $major->major_id }}">{{ $major->major_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="work_place">Địa điểm làm việc <span class="text-danger">*</span></label>
                                    <input type="text" id="work_place" name="work_place" class="form-control"
                                        placeholder="Địa điểm làm việc" required>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="fk_jobType_id">Loại hình công việc <span
                                            class="text-danger">*</span></label>
                                    <select id="fk_jobType_id" name="fk_jobType_id" class="form-select" required>
                                        <option value="">Chọn loại hình công việc</option>
                                        @foreach ($jobTypes as $jobType)
                                            <option value="{{ $jobType->jobType_id }}">{{ $jobType->jobType_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="expiried_date">Hạn nộp hồ sơ <span class="text-danger">*</span></label>
                                    <input type="date" id="expiried_date" name="expiried_date" class="form-control"
                                        required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="quantity_hire">Số lượng tuyển <span class="text-danger">*</span></label>
                                    <input type="number" id="quantity_hire" name="quantity_hire" class="form-control"
                                        min="1" value="1" required>
                                </div>
                            </div>
                        </div>

                        {{-- salary --}}
                        <div class="row mt-4">
                            <h6 class="fw-bold">Mức lương</h6>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="salary_from">Từ <span class="text-danger">*</span></label>
                                    <input type="number" id="salary_from" name="salary_from" class="form-control"
                                        min="0" value="0" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="salary_to">Đến <span class="text-danger">*</span></label>
                                    <input type="number" id="salary_to" name="salary_to" class="form-control"
                                        min="0" value="0" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="unit">Loại tiền</label>
                                    <select id="unit" name="unit" class="form-select">
                                        <option value="1">VND</option>
                                        <option value="2">USD</option>
                                        <option value="3">SGD</option>
                                    </select>
                                </div>
                            </div>
                            <input type="hidden" name="salary_range">
                        </div>
                    </div>

                    {{-- job description --}}
                    <div class="col-md-12 mb-4 p-4 bg-white rounded">
                        <div class="row mb-2">
                            <h6 class="fw-bold">MÔ TẢ CÔNG VIỆC</h6>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="description">Mô tả chung về công việc <span
                                            class="text-danger">*</span></label>
                                    <textarea id="description" name="description" class="form-control"
                                        placeholder="Những công việc mà vị trí này đảm nhận..." rows="5" required></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="requirement">Yêu cầu công việc <span class="text-danger">*</span></label>
                                    <textarea id="requirement" name="requirement" class="form-control"
                                        placeholder="Những yêu cầu mà ứng viên phải đáp ứng..." rows="5" required></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="benefits">Quyền lợi <span class="text-danger">*</span></label>
                                    <textarea id="benefits" name="benefits" class="form-control"
                                        placeholder="Những quyền lợi mà ứng viên được nhận nếu trúng tuyển..." rows="5" required></textarea>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12 p-4 bg-white rounded">
                        <div class="row">
                            <h6 class="fw-bold">THÔNG TIN LIÊN HỆ</h6>
                        </div>
                        <div class="row mb-3">
                            <div class="text-muted" style="font-size: 14px">
                                Thông tin này sẽ được hiển thị lên tin tuyển dụng để làm đầu mối liên hệ cho ứng viên
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="fk_employee_id">Người liên hệ</label>
                                    <select name="fk_employee_id" id="employees" class="form-select" required>
                                        <option value="">Chọn người liên hệ</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="contact_position">Chức danh</label>
                                    <input type="text" id="contact_position" class="form-control" disabled>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="phone_contact">Số điện thoại</label>
                                    <input type="tel" id="phone_contact" class="form-control" disabled>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="email_contact">Email</label>
                                    <input type="text" id="email_contact" class="form-control" disabled>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <div class="col-lg-3 py-3">
            <div class="p-4 ms-4 rounded bg-white">
                <button type="submit" id="btn-submit" class="btn btn-sm btn-primary w-100 mb-2">Lưu và đăng tin</button>
                <button type="button" class="btn btn-sm btn-outline-primary w-100">Lưu nháp</button>
            </div>
        </div>
    </div>
@endsection

@push('javascript')
    <script src="{{ asset('general/js/department.js') }}"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.querySelector('#form_jobPost');
            const inputs = form.querySelectorAll('input[required], select[required], textarea[required]');
            const btnSubmit = document.querySelector('#btn-submit');

            btnSubmit.addEventListener('click', function(event) {
                let isValid = true;
                console.log(inputs);

                inputs.forEach(input => {
                    const errorElement = input.nextElementSibling;
                    if (errorElement && errorElement.classList.contains('validation-error')) {
                        errorElement.remove();
                    }

                    if (!input.value.trim()) {
                        isValid = false;
                        const error = document.createElement('div');
                        error.classList.add('validation-error', 'text-danger', 'mt-1');
                        error.style.fontSize = 'smaller';
                        error.textContent = 'Trường này là bắt buộc.';
                        input.insertAdjacentElement('afterend', error);
                    }
                });

                if (isValid) {
                    const salaryFrom = document.querySelector('#salary_from').value;
                    const salaryTo = document.querySelector('#salary_to').value;
                    const unit = document.querySelector('#unit').value;

                    const salaryRange = {
                        from: salaryFrom,
                        to: salaryTo,
                        unit: unit
                    };

                    // 
                    const salaryRangeInput = document.querySelector('input[name="salary_range"]');
                    salaryRangeInput.value = JSON.stringify(salaryRange);

                    // submit form
                    form.submit();
                }
            });

            // event hide error
            inputs.forEach(input => {
                input.addEventListener('focus', function() {
                    const errorElement = input.nextElementSibling;
                    if (errorElement && errorElement.classList.contains('validation-error')) {
                        errorElement.remove();
                    }
                });
            });
        });
    </script>
@endpush
