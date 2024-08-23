<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Department;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    // Hiển thị danh sách phòng ban
    public function index()
    {
        $departments = Department::all();
        return view('admin.department.index', compact('departments'));
    }

    // Hiển thị form tạo phòng ban mới
    public function create()
    {
        return view('admin.department.create');
    }

    // Lưu phòng ban mới vào cơ sở dữ liệu
    public function store(Request $request)
    {
        // $request->validate([
        //     'department_name' => 'required|string|max:255',
        // ]);

        // Department::create($request->all());
        // return redirect()->route('admin.department.index')->with('success', 'Phòng ban đã được thêm thành công.');

        try {
            // Validate the request
            $request->validate([
                'department_name' => 'required|string|regex:/^[\pL\s]+$/u|max:255',
            ]);
    
            // Create the department
            Department::create($request->all());
    
            // Redirect with success message
            return redirect()->route('admin.department.index')->with('success', 'Phòng ban đã được thêm thành công.');
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Handle validation errors
            return redirect()->back()->withErrors($e->validator->errors())->withInput();
        } catch (\Illuminate\Database\QueryException $e) {
            // Handle unique constraint violations
            $errorCode = $e->getCode();
            $errorMessage = $e->getMessage();
    
            if ($errorCode == '23000') {
                return redirect()->back()->with('error', 'Tên phòng ban đã tồn tại. Vui lòng chọn tên khác. (Mã lỗi: ' . $errorCode . ')')->withInput();
            }
    
            // Handle other database errors
            return redirect()->back()->with('error', 'Đã xảy ra lỗi với cơ sở dữ liệu: ' . $errorMessage . ' (Mã lỗi: ' . $errorCode . ')')->withInput();
        } catch (\Exception $e) {
            // Handle other types of exceptions
            $errorMessage = $e->getMessage();
            return redirect()->back()->with('error', 'Đã xảy ra lỗi không mong muốn: ' . $errorMessage . ' (Mã lỗi: ' . $e->getCode() . ')')->withInput();
        }
    }

    // Hiển thị form chỉnh sửa phòng ban
    public function edit($id)
    {
        $department = Department::findOrFail($id);
        return view('admin.department.edit', compact('department'));
    }

    // Cập nhật phòng ban trong cơ sở dữ liệu
    public function update(Request $request, $id)
    {
        $request->validate([
            'department_name' => 'required|string|max:255',
        ]);

        $department = Department::findOrFail($id);
        $department->update($request->all());
        return redirect()->route('admin.department.index')->with('success', 'Phòng ban đã được cập nhật thành công.');
    }

    // Xóa phòng ban khỏi cơ sở dữ liệu
    public function destroy($id)
    {
        // Tìm phòng ban theo ID
        $department = Department::findOrFail($id);

        // Kiểm tra xem phòng ban có nhân viên liên quan không
        if ($department->employees()->exists()) {
            // Nếu có nhân viên, không cho phép xóa và trả về thông báo lỗi
            return redirect()->route('admin.department.index')
                ->with('error', 'Không thể xóa phòng ban vì nó có liên quan đến nhân sự.');
        }

        // Nếu không có nhân viên, thực hiện xóa phòng ban
        $department->delete();

        // Trả về thông báo thành công
        return redirect()->route('admin.department.index')
            ->with('success', 'Phòng ban đã được xóa thành công.');
    }

    // Hiển thị chi tiết phòng ban (nếu cần)
    public function show($id)
    {
        $department = Department::findOrFail($id);
        return view('admin.department.show', compact('department'));
    }
}
