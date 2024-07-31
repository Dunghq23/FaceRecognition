<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\TimekeepingController;
use App\Http\Controllers\TrainController;
use App\Models\Timekeeping;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
Route::post('/login-with-face', [AuthController::class, 'loginWithFace'])->name('login.with.face');


// Huấn luyện khuôn mặt
Route::post('/photo-train', [TrainController::class, 'TrainAllFace']);
Route::get('/train-face', function () {
    return view('auth/trainface');
});
Route::post('/save-photo-train', [TrainController::class, 'savePhoto']);
Route::post('/photo-train-image', [TrainController::class, 'TrainFace']);

// Nhận diện khuôn mặt
Route::post('/save-photo', [AuthController::class, 'savePhoto']);
Route::post('/recognize-face', [AuthController::class, 'recognizeFace']);
Route::get('/delete-images', [TrainController::class, 'deleteImages'])->name('delete.images');


// Khuôn mặt chưa biết
Route::get('/recognition-unknown-list', [TrainController::class, 'UnknownList']);
Route::post('/delete-image', [TrainController::class, 'deleteImage'])->name('delete.image');


// checkin checkout timekeeping
Route::post('/timekeeping', [TimekeepingController::class, 'timekeeping']);
// Route::post('/checkin', [TimekeepingController::class, 'checkin']);
// Route::post('/checkout', [TimekeepingController::class, 'checkout']);


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
