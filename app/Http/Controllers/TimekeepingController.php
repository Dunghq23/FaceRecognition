<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Timekeeping;
use DateTime;
use DateTimeZone;
use Illuminate\Http\Request;

class TimekeepingController extends Controller
{
    //
    public function index()
    {
        return view('timekeeping.timekeeping');
    }

    public function TimeKeeping(Request $request)
    {
        if ($request->ajax()) {
            $employee_name = $request->input('employee_name');

            // get current employee_id accessing
            $employee_id = Employee::where('employee_name', $employee_name)->value('employee_id');

            // get current date and time
            $timezone = new DateTimeZone('Asia/Bangkok'); // UTC+7 timezone
            $currentDateZone = new DateTime('now', $timezone);
            $currentDate = $currentDateZone->format('Y-m-d');
            $currnetDateTime = $currentDateZone->format('Y-m-d H:i:s');

            // handle logic checkin checkout
            $timekeeping = Timekeeping::where('fk_employee_id', $employee_id)
                ->whereDate('check_in', $currentDate)
                ->first();

            // if employee had checkin and checkout in today
            if (isset($timekeeping->check_in) && isset($timekeeping->check_out)) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'đã checkin và checkout trong ngày hôm nay!'
                ]);
            }

            // if employee had checkin
            if (isset($timekeeping)) {
                $timekeeping->check_out = $currnetDateTime;
                $timekeeping->save();
                return response()->json([
                    'status' => 'checkout',
                    'message' => 'checkout thành công!'
                ]);
            }

            // if employee hadnot checkin
            Timekeeping::create([
                'fk_employee_id' => $employee_id,
                'check_in' => $currnetDateTime
            ]);

            return response()->json([
                'status' => 'checkin',
                'message' => 'checkin thành công!'
            ]);
        }
    }

    public function StatisticsIndex()
    {
        return view('timekeeping.statistic');
    }

    public function Statistics()
    {

    }
}
