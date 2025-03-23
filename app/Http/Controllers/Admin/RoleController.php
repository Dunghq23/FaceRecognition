<?php

namespace App\Http\Controllers\Admin;

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
        // $users = User::where('account_id', '!=', Auth::id())->get();
        $users = User::all();
        $roleParents = RoleParent::all();

        return view('admin.roles.index', compact('users', 'roleParents'));
    }

    public function showRoleByUser(Request $request)
    {
        $user_id = $request->input('user_id');
        $role_id = Role::
            join('linkRoles', 'roles.role_id', '=', 'linkRoles.fk_role_id')
            ->where('linkRoles.fk_account_id', $user_id)
            ->get();

        return response()->json($role_id);
    }

    public function store(Request $request)
    {
        // if ($request->ajax()) {
        //     $roles = $request->input('role_id');
        //     $user_id = $request->input('user_id');

        //     DB::table('LinkRoleUser')->where('FK_Id_User', $user_id)->delete();

        //     if ($roles != null) {
        //         foreach ($roles as $role_id) {
        //             DB::table('LinkRoleUser')->insert([
        //                 'FK_Id_User' => $user_id,
        //                 'FK_Id_Role' => $role_id
        //             ]);
        //         }
        //     }

        //     $roles = DB::table('LinkRoleUser')
        //         ->join('Role', 'FK_Id_Role', '=', 'Id_Role')
        //         ->where('FK_Id_User', $user_id)
        //         ->select('FK_Id_Role', 'Name_Role')
        //         ->get();

        //     $redirectUrl = redirect()->route('users.index');

        //     if (!$roles->contains('FK_Id_Role', 13)) {
        //         $redirectUrl = $redirectUrl->with('type', 'success')
        //             ->with('message', 'Đăng ký vai trò thành công!');
        //     } else {
        //         $redirectUrl = $redirectUrl->with('type', 'success')
        //             ->with('message', 'Đăng ký vai trò thành công!');
        //     }

        //     return response()->json(['url' => $redirectUrl->getTargetUrl()]);
        // }
    }
}
