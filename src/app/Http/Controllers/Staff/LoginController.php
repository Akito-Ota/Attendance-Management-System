<?php

namespace App\Http\Controllers\Staff;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Auth;


class LoginController extends Controller
{
    public function create()
    {
        return view('staff.login');
    }

    public function store(LoginRequest $request)
    {
        $credentials = $request->validated();

        // ログイン成功時
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->route('attendance.create'); //出勤登録画面へ遷移
        }
        // ログイン失敗時
        return back()
            ->withErrors(['email' => 'ログイン情報が登録されていません'])
            ->onlyInput('email');
    }
    public function destroy(Request $request)
    {
        Auth::logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();

        return redirect()->route('staff.login.form');
    }
}


