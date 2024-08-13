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
        $request->validate([
            'department_name' => 'required|string|max:255',
        ]);

        Department::create($request->all());
        return redirect()->route('admin.department.index')->with('success', 'Phòng ban đã được thêm thành công.');
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
