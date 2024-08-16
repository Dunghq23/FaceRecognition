<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use App\Models\Employee;

class EmployeeRow extends Component
{

    public $departmentId;
    public $employees;

    public function __construct($departmentId)
    {
        $this->departmentId = $departmentId;

        // Nếu departmentId là 0, lấy toàn bộ nhân viên
        if ($this->departmentId == 0) {
            $this->employees = Employee::all();
        } else {
            $this->employees = Employee::where('fk_department_id', $this->departmentId)->get();
        }
    }

    public function render(): View|Closure|string
    {
        return view('components.employee-row');
    }
}
