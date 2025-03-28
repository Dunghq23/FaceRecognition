<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class JobPostRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules()
    {
        return [
            'fk_level_id' => 'required|exists:experienceLevels,level_id',
            'fk_jobType_id' => 'required|exists:jobTypes,jobType_id',
            'fk_major_id' => 'required|exists:majors,major_id',
            'fk_employee_id' => 'required|exists:employees,employee_id',
            'title' => 'required|string|max:255',
            'role_hire' => 'required|string|max:120',
            'work_place' => 'nullable|string|max:255',
            'salary_range' => 'nullable|string|max:255',
            'quantity_hire' => 'required|integer|min:1',
            'expiried_date' => 'required|date|after:today',
            'description' => 'required|string',
            'requirement' => 'required|string',
            'benefits' => 'required|string'
        ];
    }

    public function messages()
    {
        return [
            // Validation messages for fk_level_id
            'fk_level_id.required' => 'Vui lòng chọn cấp bậc cho tin tuyển dụng.',
            'fk_level_id.exists' => 'Cấp bậc bạn chọn không tồn tại trong hệ thống.',
    
            // Validation messages for fk_jobType_id
            'fk_jobType_id.required' => 'Vui lòng chọn loại hình công việc.',
            'fk_jobType_id.exists' => 'Loại hình công việc bạn chọn không tồn tại trong hệ thống.',
    
            // Validation messages for fk_major_id
            'fk_major_id.required' => 'Vui lòng chọn ngành nghề cho tin tuyển dụng.',
            'fk_major_id.exists' => 'Ngành nghề bạn chọn không tồn tại trong hệ thống.',
    
            // Validation messages for fk_employee_id
            'fk_employee_id.required' => 'Vui lòng chọn người đăng tin tuyển dụng.',
            'fk_employee_id.exists' => 'Người đăng tin bạn chọn không tồn tại trong hệ thống.',
    
            // Validation messages for title
            'title.required' => 'Tiêu đề tin tuyển dụng là bắt buộc.',
            'title.string' => 'Tiêu đề phải là một chuỗi ký tự hợp lệ.',
            'title.max' => 'Tiêu đề không được vượt quá 255 ký tự.',

            // Validation messages for role_hire
            'role_hire.required' => 'Vị trí tuyển dụng tin là bắt buộc.',
            'role_hire.string' => 'Vị trí tuyển dụng phải là một chuỗi ký tự hợp lệ.',
            'role_hire.max' => 'Vị trí tuyển dụng không được vượt quá 120 ký tự.',
    
            // Validation messages for work_place
            'work_place.string' => 'Địa điểm làm việc phải là một chuỗi ký tự hợp lệ.',
            'work_place.max' => 'Địa điểm làm việc không được vượt quá 255 ký tự.',
    
            // Validation messages for salary_range
            'salary_range.string' => 'Khoảng lương phải là một chuỗi ký tự hợp lệ.',
            'salary_range.max' => 'Khoảng lương không được vượt quá 255 ký tự.',
    
            // Validation messages for quantity_hire
            'quantity_hire.required' => 'Vui lòng nhập số lượng tuyển dụng.',
            'quantity_hire.integer' => 'Số lượng tuyển dụng phải là một số nguyên.',
            'quantity_hire.min' => 'Số lượng tuyển dụng phải lớn hơn hoặc bằng 1.',
    
            // Validation messages for expiried_date
            'expiried_date.required' => 'Vui lòng chọn hạn nộp hồ sơ.',
            'expiried_date.date' => 'Hạn nộp hồ sơ phải là một ngày hợp lệ.',
            'expiried_date.after' => 'Hạn nộp hồ sơ phải sau ngày hôm nay.',
    
            // Validation messages for description
            'description.required' => 'Vui lòng nhập mô tả công việc.',
            'description.string' => 'Mô tả công việc phải là một chuỗi ký tự hợp lệ.',
    
            // Validation messages for requirement
            'requirement.required' => 'Vui lòng nhập yêu cầu công việc.',
            'requirement.string' => 'Yêu cầu công việc phải là một chuỗi ký tự hợp lệ.',
    
            // Validation messages for benefits
            'benefits.required' => 'Vui lòng nhập quyền lợi của công việc.',
            'benefits.string' => 'Quyền lợi phải là một chuỗi ký tự hợp lệ.',
        ];
    }
}
