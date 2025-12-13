<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Staff\LoginController as StaffLoginController;
use App\Http\Controllers\Admin\LoginController as AdminLoginController;


require __DIR__ . '/staff.php';
require __DIR__ . '/admin.php';

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//{{------ログイン関連機能のみをこのファイルの集約-------}}

//スタッフログイン用
Route::get('/staff/login',  [StaffLoginController::class, 'create'])->name('staff.login.form'); //画面表示
Route::post('/staff/login', [StaffLoginController::class, 'store'])->name('staff.login'); //ログイン処理
Route::post('/staff/logout', [StaffLoginController::class, 'destroy'])->name('staff.logout'); //ロググアウト処理

//管理者ログイン用
Route::get('/admin/login',  [AdminLoginController::class, 'create'])->name('admin.login.form'); //画面表示
Route::post('/admin/login', [AdminLoginController::class, 'store'])->name('admin.login'); //ログイン処理
Route::post('/admin/logout', [AdminLoginController::class, 'destroy'])->name('admin.logout');//ロググアウト処理