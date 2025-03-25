<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Services\SystemLogService;
use App\Models\SystemLog;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SystemLogController extends Controller
{
    //
    public function index()
    {
        // have full role to view action system
        $fullAccess = Auth::user()->roles->where('role_id', 3)->first();

        $logs = null;
        $accounts = [];

        if($fullAccess) {
            $logs = SystemLog::paginate(10);
            $accounts = User::all();
        }
        else {
            $logs = SystemLog::where('fk_account_id', Auth::id())->paginate(10);
        }

        return view('admin.systemLogs.index', [
            'logs' => $logs, 
            'accounts' => $accounts,
            'access' => $fullAccess ? true : false
        ]);
    }

    public function filterLogs(Request $request)
    {
        $account_id = $request->input('account_id');
        $page = $request->input('page');
        $logs = null;
        
        if($account_id == 0) {
            $logs = SystemLogService::getLogs(null, $page, false);
        } 
        else {
            $logs = SystemLogService::getLogsByUser($account_id);
        }

        return response()->json($logs);
    }

    public function searchLogs(Request $request)
    {
        if ($request->ajax()) {
            $value = $request->input('searchValue');
            $page = $request->input('page');
            $logs = null;

            if ($value != "") {
                $logs = SystemLogService::getLogs($value);
            } else {
                $logs = SystemLogService::getLogs($value, $page, false);
            }

            return response()->json($logs);
        }
    }
}
