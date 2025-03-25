<?php

namespace App\Http\Services;

use App\Models\SystemLog;
use Illuminate\Support\Facades\Auth;

class SystemLogService {
    //
    public static function getLogsByUser($userId)
    {
        $logs = SystemLog::where('fk_account_id', $userId)->get();

        foreach ($logs as $log) {
            $log->username = $log->account->username;
            $log->employee_name = $log->account->employee->employee_name;
            $log->time = $log->getTime();
        }

        return $logs;
    }

    public static function getLogs($value, $page = null, bool $filterAction = true) {
        $logs = null;
        if ($filterAction) {
            $logs = SystemLog::where('action', 'like', '%' . $value . '%')->get();
        } else {
            $logs = SystemLog::skip($page-1 * 10)->take(10)->get();
        }

        $fullAccess = Auth::user()->roles->where('role_id', 3)->first();
        if(!$fullAccess) {
            $logs = $logs->filter(function($log) {
                return $log->fk_account_id == Auth::user()->account_id;
            });
        }

        foreach ($logs as $log) {
            $log->username = $log->account->username;
            $log->employee_name = $log->account->employee->employee_name;
            $log->time = $log->getTime();
        }

        return $logs;
    }
}
