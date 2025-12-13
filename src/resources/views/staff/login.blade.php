@extends('layouts.staff')

@section('title', '従業員ログイン')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/login.css') }}">
@endpush

@section('content')
<div class="login-wrapper">
    <h1 class="login-title">ログイン</h1>
    <div class="login-container">
        <form action="{{ route('staff.login') }}" method="post">
            @csrf
            <div class="form-group">
                <label for="email" class="form-label">メールアドレス</label>
                <input id="email" name="email" type="email" class="form-input" autocomplete="email">
                @error('email')
                <div class="form-error">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label for="password" class="form-label">パスワード</label>
                <input id="password" name="password" type="password" class="form-input" autocomplete="current-password">
                @error('password')
                <div class="form-error">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-action">
                <button type="submit" class="login-button">ログインする</button>
            </div>
        </form>

        <div class="register-link">
            <a href="{{ route('staff.register.form') }}">会員登録はこちら</a>
        </div>
    </div>
</div>
@endsection