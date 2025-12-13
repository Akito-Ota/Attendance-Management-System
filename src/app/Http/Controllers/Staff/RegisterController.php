<?php

namespace App\Http\Controllers\Staff; //会員登録用

use App\Http\Requests\RegisterRequest;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;

class RegisterController extends Controller
{
    public function create()
    {
        return view('staff.register');
    }

    public function store(RegisterRequest $request)
    {
        $data = $request->validated();

        $user = User::create([
            'name'     => $data['name'],
            'email'    => $data['email'],
            'password' => Hash::make($data['password']),
            'role' => 'staff',
        ]);

        Auth::login($user);
        $request->session()->regenerate();

        return redirect()->route('staff.login.form');
    }
}
