<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AttendanceController;
use App\Http\Controllers\Admin\StaffController;
use App\Http\Controllers\Admin\CorrectionController;
use App\Http\Controllers\CsvDownloadController;




Route::middleware('auth','admin')->group(
    function () {

//出勤一覧および詳細
Route::get('/admin/attendance/index', [AttendanceController::class, 'index'])->name('admin.attendance.index'); //出勤一覧の画面表示
Route::get('/admin/attendance/index/{id}', [AttendanceController::class, 'show'])->name('admin.attendance.show'); //出勤の詳細画面

//勤怠修正機能
Route::put('/admin/attendance/index/{id}', [AttendanceController::class, 'update'])->name('admin.attendance.update'); 


//スタッフ一覧
Route::get('/admin/staff/index', [StaffController::class, 'index'])->name('admin.staff.index'); //スタッフ一覧の画面表示
Route::get('/admin/staff/index/{id}', [StaffController::class, 'show'])->name('admin.staff.show'); //スタッフ月次の詳細画面
Route::get('/admin/staff/index/{id}/csv', [CsvDownloadController::class, 'export'])->name('admin.staff.csv');//csvダウンロード

//申請一覧
Route::get('/admin/correction/index', [CorrectionController::class, 'index'])->name('admin.correction.index'); 
//申請一覧の画面表示
Route::get('/admin/correction/index/{id}',[CorrectionController::class, 'show'])->name('admin.correction.show');
//申請詳細画面
Route::put('/admin/correction/index/{id}',[CorrectionController::class,'approve'])->name('admin.correction.approve');
//承認機能




    });