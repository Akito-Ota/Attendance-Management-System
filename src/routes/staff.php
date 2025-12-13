<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Staff\RegisterController;
use App\Http\Controllers\Staff\AttendanceController;
use App\Http\Controllers\Staff\CorrectionController;
use App\Http\Controllers\Staff\RestController;

//会員登録ページ用
Route::get('/register', [RegisterController::class, 'create'])->name('staff.register.form'); //画面表示
Route::post('/register', [RegisterController::class, 'store'])->name('staff.register'); //会員登録

Route::middleware('auth')->group(
    function () {

//出勤・休憩・退勤関連
Route::get('/attendance', [AttendanceController::class, 'create'])->name('attendance.create'); //画面表示
Route::post('/attendance/clock-in', [AttendanceController::class, 'createclockin'])->name('attendance.clockin'); //出勤登録
Route::post('/attendance/clock-out', [AttendanceController::class, 'createclockout'])->name('attendance.clockout');  //退勤登録
Route::post('/attendance/rest/start', [RestController::class, 'start'])->name('rest.start'); //休憩登録
Route::post('/attendance/rest/end', [RestController::class, 'end'])->name('rest.end');//休憩終了登録

//出勤一覧登録
Route::get('/attendance/index', [AttendanceController::class, 'index'])->name('attendance.index'); //出勤一覧の画面表示

//出勤詳細画面
Route::get('/attendance/detail/{id}', [AttendanceController::class, 'show'])->name('attendance.show'); //出勤詳細画面
Route::patch('/attendance/detail/{id}', [CorrectionController::class, 'update'])->name('attendance.update');//申請機能

//申請画面
Route::get('/correction', [CorrectionController::class, 'index'])->name('correction.index'); //画面表示
Route::get('/correction/detail/{id}',[CorrectionController::class,'show'])->name('correction.show')->whereNumber('id');//申請後の詳細画面
    });