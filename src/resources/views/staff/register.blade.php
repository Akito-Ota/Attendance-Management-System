@extends('layouts.staff')

@section('title', '会員登録')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/register.css') }}">
@endpush

@section('content')
<div class="register">
    <div class="register__inner">
        <h1 class="register__title">会員登録</h1>

        <form action="{{ route('staff.register') }}" method="post" class="form">
            @csrf

            <div class="form__row">
                <label for="name" class="form__label">名前</label>
                <input id="name" name="name" type="text" class="form__control" autocomplete="name">
                @error('name') <div class="form__error">{{ $message }}</div> @enderror
            </div>

            <div class="form__row">
                <label for="email" class="form__label">メールアドレス</label>
                <input id="email" name="email" type="email" class="form__control" autocomplete="email">
                @error('email') <div class="form__error">{{ $message }}</div> @enderror
            </div>

            <div class="form__row">
                <label for="password" class="form__label">パスワード</label>
                <input id="password" name="password" type="password" class="form__control" autocomplete="new-password">
                @error('password') <div class="form__error">{{ $message }}</div> @enderror
            </div>

            <div class="form__row">
                <label for="password_confirmation" class="form__label">パスワード確認</label>
                <input id="password_confirmation" name="password_confirmation" type="password" class="form__control" autocomplete="new-password">
                @error('password_confirmation') <div class="form__error">{{ $message }}</div> @enderror
            </div>

            <div class="form__actions">
                <button type="submit" class="button button--primary">登録する</button>
            </div>

            <div class="register__link-wrapper">
                <a class="register__login-link" href="{{ route('staff.login.form') }}">ログインはこちら</a>
            </div>
        </form>
    </div>
</div>
@endsection