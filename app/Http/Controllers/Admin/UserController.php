<?php

namespace App\Http\Controllers\Admin;

use App\Events\SystemLogEvent;
use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Models\Employee;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    //
    public function index()
    {
        $data = User::where('account_id', '!=', Auth::id())->paginate(5);
        // event(new SystemLogEvent('Xem danh sách người dùng'));
        return view('admin.users.index', compact('data'));
    }

    public function create()
    {
        $employees = Employee::all();
        $departments = Department::all();
        return view('admin.users.create', compact('employees', 'departments'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'Employee_Id' => [
                'required',
                Rule::unique('accounts', 'fk_employee_id')
            ],
            'UserName' => 'required|unique:accounts,username|regex:/^\S*$/',
            'Password' => 'required|min:6',
        ], [
            'Employee_Id.required' => 'Vui lòng chọn người dùng tương ứng',
            'Employee_Id.unique' => 'Nhân viên này đã có tài khoản',
            'UserName.required' => 'Tài khoản không được để trống',
            'UserName.unique' => 'Tài khoản đã tồn tại',
            'UserName.regex' => 'Tài khoản không được có khoảng trắng',
            'Password.required' => 'Mật khẩu không được để trống',
            'Password.min' => 'Mật khẩu phải có ít nhất 6 ký tự',
        ]);

        $user = User::create([
            'fk_employee_id' => $data['Employee_Id'],
            'username' => $data['UserName'],
            'password' => Hash::make($data['Password'])
        ]);

        event(new SystemLogEvent('Thêm tài khoản người dùng', 'accounts', $user->account_id, details: $user));

        return redirect()->route('management.users.index')->with('success', 'Thêm người dùng thành công!');
    }

    public function edit(string $id)
    {
        $user = User::findOrFail($id);
        if (!$user) {
            return back()->with('error', 'Người dùng không tồn tại');
        }
        return view('admin.users.edit', ['user' => $user]);
    }

    public function update(Request $request, string $id)
    {
        $data = $request->validate([
            'Password' => 'required|min:6',
        ], [
            'Password.required' => 'Mật khẩu không được để trống',
            'Password.min' => 'Mật khẩu phải có ít nhất 6 ký tự',
        ]);

        $user = User::findOrFail($id);
        if (!$user) {
            return back()->with('error', 'Người dùng không tồn tại');
        }

        $user->update([
            'password' => Hash::make($data['Password'])
        ]);

        event(new SystemLogEvent('Cập nhật tài khoản người dùng', 'accounts', $user->account_id, $user));

        return redirect()->route('management.users.index')->with('success', 'Cập nhật thông tin người dùng thành công!');
    }

    public function destroy(string $id)
    {
        DB::beginTransaction();
        try {
            $user = User::findOrFail($id);
            if (!$user) {
                return back()->with('error', 'Người dùng không tồn tại');
            }

            if ($id == Auth::id()) {
                return back()->with('error', 'Không thể tự xoá tài khoản đang thao tác!');
            }

            $user->delete();

            DB::commit();

            event(new SystemLogEvent('Xoá tài khoản người dùng', 'accounts', $user->account_id, $user));

            return back()->with('success', 'Xoá người dùng thành công!');
        } catch (\Throwable $th) {
            DB::rollBack();
            Log::error('error delete user', [$th->getMessage()]);
            return back()->with('error', 'Xoá người dùng thất bại!');
        }
    }

    public function searchUsers(Request $request)
    {
        if ($request->ajax()) {
            $search = $request->input('searchValue');
            $data = null;

            if ($search != "") {
                $data = User::where('username', 'like', '%' . $search . '%')
                    ->where('account_id', '!=', Auth::id())
                    // ->orWhere('username', 'like', '%' . $search . '%')
                    // ->select('account_id', 'Name', 'username')
                    ->get();
            } else {
                $data = User::where('account_id', '!=', Auth::id())->get();
            }

            foreach ($data as $user) {
                $user->name = $user->employee->employee_name;
                // $user->roles = $user->roles;
            }

            return response()->json($data);
        }
    }
}
