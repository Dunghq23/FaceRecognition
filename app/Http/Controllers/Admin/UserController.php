<?php

namespace App\Http\Controllers\Admin;

use App\Events\SystemLogEvent;
use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    //
    public function index()
    {
        $data = User::where('account_id', '!=', Auth::id())->paginate(5);
        event(new SystemLogEvent('Xem danh sách người dùng'));
        return view('admin.users.index', compact('data'));
    }

    public function create()
    {
        $employees = Employee::all();
        return view('admin.users.create', compact('employees'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'Name' => 'required',
            'UserName' => 'required|unique:User|regex:/^\S*$/',
            'Password' => 'required|min:6',
        ], [
            'Name.required' => 'Tên không được để trống',
            'UserName.required' => 'Tài khoản không được để trống',
            'UserName.unique' => 'Tài khoản đã tồn tại',
            'UserName.regex' => 'Tài khoản không được có khoảng trắng',
            'Password.required' => 'Mật khẩu không được để trống',
            'Password.min' => 'Mật khẩu phải có ít nhất 6 ký tự',
        ]);
        $data['Password'] = bcrypt($data['Password']);
        $data['Id_User'] = User::getIdMax();
        User::create($data);
        return redirect()->route('users.index')->with([
            'type' => 'success',
            'message' => 'Thêm người dùng thành công'
        ]);
    }

    public function edit(string $id)
    {
        $user = User::findOrFail($id);
        if (!$user) {
            return back()->with('error', 'Người dùng không tồn tại');
        }
        return view('admin.users.edit', ['user' => $user]);
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'Name' => 'required',
            'UserName' => 'required|unique:User|regex:/^\S*$/',
            'Password' => 'required|min:6',
        ], [
            'Name.required' => 'Tên không được để trống',
            'UserName.required' => 'Tài khoản không được để trống',
            'UserName.unique' => 'Tài khoản đã tồn tại',
            'UserName.regex' => 'Tài khoản không được có khoảng trắng',
            'Password.required' => 'Mật khẩu không được để trống',
            'Password.min' => 'Mật khẩu phải có ít nhất 6 ký tự',
        ]);
        $data['Password'] = bcrypt($data['Password']);
        $data['Id_User'] = User::getIdMax();
        User::create($data);
        return redirect()->route('users.index')->with([
            'type' => 'success',
            'message' => 'Thêm người dùng thành công'
        ]);
    }

    public function destroy(string $id)
    {
        $user = User::findOrFail($id);
        if (!$user) {
            return back()->with('error', 'Người dùng không tồn tại');
        }

        if ($id == Auth::id()) {
            return back()->with('error', 'Không thể tự xoá tài khoản đang thao tác!');
        }

        $user->delete();
        return back()->with('success', 'Xoá người dùng thành công!');
    }

    public function searchUsers(Request $request)
    {
        if ($request->ajax()) {
            $search = $request->input('searchValue');
            // if ($search != "") {
            //     $data = DB::table('User')
            //         ->where('Name', 'like', '%' . $search . '%')
            //         ->orWhere('UserName', 'like', '%' . $search . '%')
            //         ->select('Id_User', 'Name', 'UserName')
            //         ->get();
            // } else {
            //     $data = DB::table('User')
            //         ->select('Id_User', 'Name', 'UserName')
            //         ->get();
            // }
            // return response()->json($data);
        }
    }
}
