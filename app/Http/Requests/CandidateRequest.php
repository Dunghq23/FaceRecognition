<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CandidateRequest extends FormRequest
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
            'fk_origin_id' => 'required|exists:candidateOrigins,origin_id',
            'fk_jobPost_id' => 'required|exists:jobPosts,jobPost_id',
            'full_name' => 'required|string|max:255',
            'email' => 'required|email|unique:candidates,email,' . ($this->candidate ? $this->candidate->candidate_id : ''),
            'phone' => 'required|string|max:50',
            'birthday' => 'required|date|before:today',
            'gender' => 'required|in:F,M',
            'address' => 'required|string|max:255',
            'apply_time' => 'required|date',
            'resumePath' => 'nullable|string|max:500',
            'status' => 'required|in:0,1,2,3'
        ];
    }

    public function messages()
    {
        return [
            // Messages for fk_origin_id
            'fk_origin_id.required' => 'Vui lòng chọn nguồn ứng viên.',
            'fk_origin_id.exists' => 'Nguồn ứng viên không tồn tại trong hệ thống.',

            // Messages for fk_jobPost_id
            'fk_jobPost_id.required' => 'Vui lòng chọn tin tuyển dụng.',
            'fk_jobPost_id.exists' => 'Tin tuyển dụng không tồn tại trong hệ thống.',

            // Messages for full_name
            'full_name.required' => 'Vui lòng nhập họ và tên.',
            'full_name.string' => 'Họ và tên phải là một chuỗi ký tự.',
            'full_name.max' => 'Họ và tên không được vượt quá 255 ký tự.',

            // Messages for email
            'email.required' => 'Vui lòng nhập email.',
            'email.email' => 'Email không đúng định dạng.',
            'email.unique' => 'Email này đã được sử dụng.',

            // Messages for phone
            'phone.required' => 'Vui lòng nhập số điện thoại.',
            'phone.string' => 'Số điện thoại phải là một chuỗi ký tự.',
            'phone.max' => 'Số điện thoại không được vượt quá 50 ký tự.',

            // Messages for birthday
            'birthday.required' => 'Vui lòng nhập ngày sinh.',
            'birthday.date' => 'Ngày sinh không đúng định dạng.',
            'birthday.before' => 'Ngày sinh phải trước ngày hiện tại.',

            // Messages for gender
            'gender.required' => 'Vui lòng chọn giới tính.',
            'gender.in' => 'Giới tính không hợp lệ.',

            // Messages for address
            'address.required' => 'Vui lòng nhập địa chỉ.',
            'address.string' => 'Địa chỉ phải là một chuỗi ký tự.',
            'address.max' => 'Địa chỉ không được vượt quá 255 ký tự.',

            // Messages for apply_time
            'apply_time.required' => 'Vui lòng nhập thời gian nộp hồ sơ.',
            'apply_time.date' => 'Thời gian nộp hồ sơ không đúng định dạng.',

            // Messages for resumePath
            'resumePath.string' => 'Đường dẫn file hồ sơ phải là một chuỗi ký tự.',
            'resumePath.max' => 'Đường dẫn file hồ sơ không được vượt quá 500 ký tự.',

            // Messages for status
            'status.required' => 'Vui lòng chọn trạng thái.',
            'status.in' => 'Trạng thái không hợp lệ.'
        ];
    }
}
