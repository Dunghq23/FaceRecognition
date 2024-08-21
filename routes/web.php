<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\TimekeepingController;
use App\Http\Controllers\Admin\DepartmentController;
use App\Http\Controllers\Admin\EmployeeController;
use App\Http\Controllers\TrainController;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
})->name('home');

// Huấn luyện khuôn mặt
Route::post('/photo-train', [TrainController::class, 'TrainAllFace']);
Route::get('/train-face', [TrainController::class, 'index'])->name('trainface.index');
Route::post('/save-photo-train', [TrainController::class, 'savePhoto']);
Route::post('/photo-train-image', [TrainController::class, 'TrainFace']);

// Nhận diện khuôn mặt
Route::post('/save-photo', [AuthController::class, 'savePhoto']);
Route::post('/recognize-face', [AuthController::class, 'recognizeFace']);
Route::get('/delete-images', [TrainController::class, 'deleteImages'])->name('delete.images');


// Khuôn mặt chưa biết
Route::get('/recognition-unknown-list', [TrainController::class, 'UnknownList'])->name('recognition.index');
Route::post('/delete-image', [TrainController::class, 'deleteImage'])->name('delete.image');


// checkin checkout timekeeping
Route::get('/timekeeping', [TimekeepingController::class, 'index'])->name('timekeeping.index')->middleware('check.ip');;
Route::post('/timekeeping', [TimekeepingController::class, 'timekeeping']);

// statistics
Route::get('/statistics', [TimekeepingController::class, 'StatisticsIndex'])->name('timekeeping.statistic');
Route::post('/statistics', [TimekeepingController::class, 'statistics']);

// detail statistics
Route::get('statistics/{employee_id}', [TimekeepingController::class, 'DetailStatisticIndex'])->name('timekeeping.statistic.detail');
Route::post('/statisticsByEmployee', [TimekeepingController::class, 'StatisticsByEmployee']);


// Check Kết nối csdl
Route::get('/check-db-connection', function () {
    try {
        DB::connection()->getPdo();
        return "Connected successfully to database: " . DB::connection()->getDatabaseName();
    } catch (\Exception $e) {
        return "Could not connect to database. Error: " . $e->getMessage();
    }

    // $serverName = "LAPTOP-OJF6T1N2";
    // $connectionOptions = array(
    //     "Database" => "TimeKeeping",
    //     "TrustServerCertificate" => "yes"
    // );

    // // Try to connect
    // $conn = sqlsrv_connect($serverName, $connectionOptions);
    // if ($conn === false) {
    //     die(print_r(sqlsrv_errors(), true));
    // } else {
    //     echo "Connected successfully!";
    // }
});



// Quản lý 
Route::prefix('admin')->name('admin.')->group(function () {
    // DepartmentController (Quản lý phòng ban)
    Route::get('/department', [DepartmentController::class, 'index'])->name('department.index');
    Route::get('/department/create', [DepartmentController::class, 'create'])->name('department.create');
    Route::post('/department', [DepartmentController::class, 'store'])->name('department.store');
    Route::get('/department/{id}', [DepartmentController::class, 'show'])->name('department.show');
    Route::get('/department/{id}/edit', [DepartmentController::class, 'edit'])->name('department.edit');
    Route::put('/department/{id}', [DepartmentController::class, 'update'])->name('department.update');
    Route::delete('/department/{id}', [DepartmentController::class, 'destroy'])->name('department.destroy');

    // EmployeeController (Quản lý nhân viên)
    Route::get('/employee', [EmployeeController::class, 'index'])->name('employee.index');
    Route::get('/employee/create', [EmployeeController::class, 'create'])->name('employee.create');
    Route::post('/employee', [EmployeeController::class, 'store'])->name('employee.store');
    Route::get('/employee/{id}', [EmployeeController::class, 'show'])->name('employee.show');
    Route::get('/employee/{id}/edit', [EmployeeController::class, 'edit'])->name('employee.edit');
    Route::patch('/employee/{id}', [EmployeeController::class, 'update'])->name('employee.update');
    Route::delete('/employee/{id}', [EmployeeController::class, 'destroy'])->name('employee.destroy');

    // ajax
    Route::post('/getEmployeesByDepartment', [EmployeeController::class, 'getEmployeesByDepartmentAjax']);

    Route::get('/employees-by-department/{id}', [EmployeeController::class, 'getEmployeesByDepartment']);


});