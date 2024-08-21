<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Models\Employee;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    public function index()
    {
        $departments = Department::withCount('employees')->get(); // Lấy số lượng nhân viên trong từng phòng ban
        $totalEmployees = Employee::count(); // Tổng số nhân viên
        $employees = Employee::all();

        return view('admin.employee.index', compact('employees', 'departments', 'totalEmployees'));
    }

    // Hiển thị form tạo nhân viên mới
    public function create()
    {
        $departments = Department::all();
        return view('admin.employee.create', compact('departments'));
    }

    // Lưu Nhân viên mới vào cơ sở dữ liệu
    public function store(Request $request)
    {
        $request->validate([
            'employee_username' => 'required|string|max:20',
            'employee_name' => 'required|string|max:100',
            'email' => 'required|string|email|max:100|unique:employees',
            'phone_number' => 'nullable|string|max:15',
            'address' => 'nullable|string|max:255',
            'date_of_birth' => 'nullable|date',
            'gender' => 'nullable|boolean',
            'position' => 'nullable|string|max:50',
            'fk_department_id' => 'required|exists:departments,department_id',
            'start_date' => 'nullable|date',
            'salary' => 'nullable|numeric',
            'employment_status' => 'nullable|boolean',
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'notes' => 'nullable|string',
        ]);

        if ($request->hasFile('profile_picture')) {
            // Lưu file vào thư mục public/profile_pictures
            $imageName = time() . '.' . $request->profile_picture->extension();
            $request->profile_picture->move(public_path('profile_pictures'), $imageName);

            // Lưu đường dẫn ảnh vào cơ sở dữ liệu
            $profilePicturePath = 'profile_pictures/' . $imageName;
        } else {
            $profilePicturePath = null;
        }

        // Đảm bảo rằng các giá trị bit cho 'gender' và 'employment_status' được đặt đúng cách
        $data = $request->all();
        $data['profile_picture'] = "public/" . $profilePicturePath;
        $data['gender'] = $request->has('gender') ? (bool) $request->input('gender') : null;
        $data['employment_status'] = $request->has('employment_status') ? (bool) $request->input('employment_status') : null;

        Employee::create($data);

        return redirect()->route('admin.employee.index')->with('success', 'Nhân viên đã được thêm thành công.');
    }

    // Hiển thị form chỉnh sửa nhân viên
    public function edit($id)
    {
        $departments = Department::all();
        $employee = Employee::findOrFail($id);
        return view('admin.employee.edit', compact('employee', 'departments'));
    }

    // Cập nhật nhân viên trong cơ sở dữ liệu
    public function update(Request $request, $id)
    {
        $request->validate([
            'employee_username' => 'required|string|max:20',
            'employee_name' => 'required|string|max:100',
            // 'email' => 'required|string|email|max:100|unique:employees,email,' . $id, // Cập nhật email cho phép trùng lặp cho chính nhân viên
            'phone_number' => 'nullable|string|max:15',
            'address' => 'nullable|string|max:255',
            'date_of_birth' => 'nullable|date',
            'gender' => 'nullable|boolean',
            'position' => 'nullable|string|max:50',
            'fk_department_id' => 'required|exists:departments,department_id',
            'start_date' => 'nullable|date',
            'salary' => 'nullable|numeric',
            'employment_status' => 'nullable|boolean',
            'profile_picture' => 'nullable|string|max:255',
            'notes' => 'nullable|string',
        ]);

        $employee = Employee::findOrFail($id);

        // Kiểm tra và xử lý ảnh avatar mới nếu người dùng upload
        if ($request->hasFile('profile_picture')) {
            // Lưu ảnh mới vào thư mục public/profile_pictures
            $imageName = time() . '.' . $request->profile_picture->extension();
            $request->profile_picture->move(public_path('profile_pictures'), $imageName);

            // Xóa ảnh cũ nếu có (không bắt buộc)
            if ($employee->profile_picture && file_exists(public_path($employee->profile_picture))) {
                unlink(public_path($employee->profile_picture));
            }

            // Cập nhật đường dẫn ảnh mới vào database
            $employee->profile_picture = 'profile_pictures/' . $imageName;
        }

        $employee->update($request->all());

        return redirect()->route('admin.employee.index')->with('success', 'Nhân viên đã được cập nhật thành công.');
    }

    // Xóa nhân viên khỏi cơ sở dữ liệu
    public function destroy($id)
    {
        // Tìm nhân viên theo ID
        $employee = Employee::findOrFail($id);

        // Kiểm tra xem nhân viên có dữ liệu chấm công hay không?
        if ($employee->timekeepings()->exists()) {
            // Nếu có dữ liệu chấm công, không cho phép xóa và trả về thông báo lỗi
            return redirect()->route('admin.employee.index')
                ->with('error', 'Nhân viên này có dữ liệu chấm công nên không thể xóa!');
        }

        // Nếu không có, xóa nhân viên
        $employee->delete();

        // Trả về thông báo thành công
        return redirect()->route('admin.employee.index')
            ->with('success', 'Nhân viên đã được xóa thành công.');
    }

    // Hiển thị chi tiết nhân viên
    public function show($id)
    {
        $departments = Department::all();
        $employee = Employee::findOrFail($id);
        return view('admin.employee.show', compact('employee', 'departments'));
    }


    // Trả về nhân viên theo phòng ban
    public function getEmployeesByDepartment($department_id)
    {
        // $departments = Department::withCount('employees')->get();

        // if ($department_id == 0) {
        //     $employees = Employee::all();
        // } else {
        //     $employees = Employee::all()->where('fk_department_id', $department_id)->where('fk_department_id', $department_id);
        // }

        // // Lọc phòng ban từ danh sách để có thông tin cần thiết
        // $filteredDepartments = $departments->map(function ($department) use ($employees) {
        //     return [
        //         'department_id' => $department->department_id,
        //         'department_name' => $department->department_name,
        //         'employees_count' => $employees->count()
        //     ];
        // });

        // return response()->json([
        //     'employees' => $employees,
        //     'departments' => $filteredDepartments
        // ]);

        $employees = ($department_id == 0)
            ? Employee::all()
            : Employee::where('fk_department_id', $department_id)->get();
        // Render phần HTML cho bảng nhân viên
        $employeeHtml = view('components.employee-row', ['employees' => $employees])->render();

        // Lấy thông tin phòng ban
        $department = Department::withCount('employees')->find($department_id);

        return response()->json([
            'employeeHtml' => $employeeHtml,
            'department' => $department
        ]);
        // return view('components.employee-row', ['employees' => $employees])->render();
    }

    public function getEmployeesByDepartmentAjax(Request $request) 
    {
        if($request->ajax()){
            $department_id = $request->input('department_id');
            $department = Department::find($department_id);
            $employees = $department->employees()->get();
            return response()->json([
                'employees' => $employees
            ]);
        }
    }
}
