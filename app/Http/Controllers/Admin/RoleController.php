<?php

namespace App\Http\Controllers\Admin;

use App\Events\SystemLogEvent;
use App\Http\Controllers\Controller;
use App\Models\LinkRole;
use App\Models\Role;
use App\Models\RoleParent;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleController extends Controller
{
    //
    public function index()
    {
        $users = User::where('account_id', '!=', Auth::id())->get();
        $roleParents = RoleParent::all();

        // event(new SystemLogEvent('Xem quyền người dùng'));

        return view('admin.roles.index', compact('users', 'roleParents'));
    }

    public function showRoleByUser(Request $request)
    {
        $user_id = $request->input('user_id');
        $role_id = Role::join('linkRoles', 'roles.role_id', '=', 'linkRoles.fk_role_id')
            ->where('linkRoles.fk_account_id', $user_id)
            ->get();

        return response()->json($role_id);
    }

    public function store(Request $request)
    {
        if ($request->ajax()) {
            $roles = $request->input('role_id');
            $user_id = $request->input('user_id');

            $userFound = User::findOrFail($user_id);

            if(!$userFound) {
                return response()->json([
                    'status' => 'error',
                    'message' => "Người dùng không tồn tại!"
                ]);
            }

            LinkRole::where('fk_account_id', $user_id)->delete();

            if ($roles != null) {
                foreach ($roles as $role_id) {
                    LinkRole::create([
                        'fk_account_id' => $user_id,
                        'fk_role_id' => $role_id
                    ]);
                }
            }

            event(new SystemLogEvent('Cập nhật quyền người dùng', 'linkRoles'));

            return response()->json([
                'status' => 'success',
                'message' => "Đăng ký vai trò thành công!"
            ]);
        }
    }
}
