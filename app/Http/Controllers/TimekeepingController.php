<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Timekeeping;
use DateInterval;
use DatePeriod;
use DateTime;
use DateTimeZone;
use Exception;
use Illuminate\Http\Request;

class TimekeepingController extends Controller
{
    //
    public function index()
    {
        return view('timekeeping.index');
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

    public function Statistics(Request $request)
    {
        if ($request->ajax()) {
            $timeStart = $request->input('timeStart');
            $timeEnd = $request->input('timeEnd');
            $date = $request->input('datePicker');

            $dateObject = DateTime::createFromFormat('d/m/Y', $date);
            $currentDate = $dateObject->format('Y-m-d');

            $expectedStartDateTime = new DateTime("$currentDate $timeStart");
            $expectedEndDateTime = new DateTime("$currentDate $timeEnd");

            $employees = Employee::all();

            // get current datetime
            foreach ($employees as $employee) {
                $timekeeping = Timekeeping::whereDate('check_in', $currentDate)
                    ->where('fk_employee_id', $employee->employee_id)
                    ->first();
                $employee->department = $employee->department->department_name;
                if ($timekeeping) {
                    $date = new DateTime($timekeeping->check_in);
                    $employee->check_in = $date->format('H:i d-m-Y');
                    // calculate time lately
                    $minutesLate = $this->calculateMinutesEarlyLately($expectedStartDateTime, $date);
                    $employee->lately = $date > $expectedStartDateTime ? $minutesLate : null;
                    if ($timekeeping->check_out) {
                        $date = new DateTime($timekeeping->check_out);
                        $employee->check_out = $date->format('H:i d-m-Y');
                        // // calculate time early
                        $minutesEarly = $this->calculateMinutesEarlyLately($expectedEndDateTime, $date);
                        $employee->early = $date < $expectedEndDateTime ? $minutesEarly : null;
                    } else {
                        $employee->check_out = "Chưa thực hiện";
                    }
                } else {
                    $employee->check_in = "Chưa thực hiện";
                    $employee->check_out = "Chưa thực hiện";
                }
            }

            return response()->json([
                'employees' => $employees,
                'status' => 'success'
            ]);
        }

        return response()->json([
            'status' => 'error'
        ]);
    }

    public function StatisticsByEmployee(Request $request)
    {
        if ($request->ajax()) {
            $employee_id = $request->input('employee_id');
            $timeStart = $request->input('time_start');
            $timeEnd = $request->input('time_end');
            $date = $request->input('dateView');

            $employee = Employee::find($employee_id);;

            // get all day in month
            $daysInMonth = $this->getDaysInMonth($date);

            $timeEmployees = [];
            $timekeepings = [];
            foreach ($employee->timekeepings as $timekeeping) {
                $checkInDate = (new DateTime($timekeeping->check_in))->format('Y-m-d');
                array_push($timeEmployees, $checkInDate);
            }

            foreach ($daysInMonth as $day) {
                if (in_array($day, $timeEmployees)) {
                    $expectedStartDateTime = new DateTime("$day $timeStart");
                    $expectedEndDateTime = new DateTime("$day $timeEnd");
                    $timekeeping = $employee->timekeepings()->whereDate('check_in', $day)->first();
                    if ($timekeeping) {
                        $date = new DateTime($timekeeping->check_in);
                        $check_in = $date->format('H:i d-m-Y');
                        // calculate time lately
                        $minutesLate = $this->calculateMinutesEarlyLately($expectedStartDateTime, $date);
                        $lately = $date > $expectedStartDateTime ? $minutesLate : 0;
                        if ($timekeeping->check_out) {
                            $date = new DateTime($timekeeping->check_out);
                            $check_out = $date->format('H:i d-m-Y');
                            // // calculate time early
                            $minutesEarly = $this->calculateMinutesEarlyLately($expectedEndDateTime, $date);
                            $early = $date < $expectedEndDateTime ? $minutesEarly : 0;

                            $total = $this->calculateTotalHours($check_in, $check_out);
                        } else {
                            $check_out = "Chưa thực hiện";
                            $early = 0;
                            $total = 0;
                        }
                    } else {
                        $check_in = "";
                        $check_out = "";
                        $early = 0;
                        $lately = 0;
                        $total = 0;
                    }

                    array_push($timekeepings, [
                        'day' => (new DateTime($day))->format('d/m/Y'),
                        'check_in' => $check_in,
                        'check_out' => $check_out,
                        'lately' => $lately,
                        'early' => $early,
                        'totalHours' => $total
                    ]);
                } else {
                    array_push($timekeepings, [
                        'day' => (new DateTime($day))->format('d/m/Y'),
                        'check_in' => "",
                        'check_out' => "",
                        'lately' => 0,
                        'early' => 0,
                        'totalHours' => 0
                    ]);
                }
            }

            $data = [
                'employee_id' => $employee->employee_id,
                'employee_name' => $employee->employee_name,
                'department' => $employee->department->department_name,
                'timekeepings' => $timekeepings
            ];

            return response()->json([
                'data' => $data,
                'status' => 'success'
            ]);
        }
    }

    function calculateTotalHours($timeCheckIn, $timeCheckOut) {
        // Create DateTime objects from the input times
        $checkIn = new DateTime($timeCheckIn);
        $checkOut = new DateTime($timeCheckOut);
    
        // Calculate the difference between the two DateTime objects
        $interval = $checkIn->diff($checkOut);
    
        // Convert the difference to total hours
        $totalHours = $interval->days * 24 + $interval->h + $interval->i / 60 + $interval->s / 3600;
    
        return round($totalHours, 2);
    }

    function calculateMinutesEarlyLately($expectedDateTime, $date)
    {
        $interval = $expectedDateTime->diff($date);
        $minutesLate = $interval->days * 24 * 60 + $interval->h * 60 + $interval->i;
        return $minutesLate;
    }

    function getDaysInMonth($date)
    {
        $daysInMonth = [];
        $date = DateTime::createFromFormat('Y-m', $date);

        if ($date === false) {
            return [];
        }

        $startDay = $date->format('Y-m-01'); // First day of the month
        $endDay = $date->format('Y-m-t'); // Last day of the month

        $period = new DatePeriod(
            new DateTime($startDay),
            new DateInterval('P1D'),
            (new DateTime($endDay))->modify('+1 day')
        );

        foreach ($period as $day) {
            $daysInMonth[] = $day->format('Y-m-d');
        }

        return $daysInMonth;
    }

    public function DetailStatisticIndex(string $employee_id)
    {
        return view('timekeeping.detailStatistic');
    }
}
