<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>@yield('title', 'Attendance-Management-System')</title>
    <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}">
    <link rel="stylesheet" href="{{ asset('css/staff.css') }}">
    @stack('styles')
</head>

<body>
    <header class="site-header">
        <div class="site-logo">
            <img src="{{ asset('images/logo.svg') }}" alt="会社ロゴ">
        </div>
        <div class="header-nav">
            @auth
            <ul class="nav-list">
                <li class="nav-item"><a href="{{ route('attendance.create') }}">勤怠</a></li>
                <li class="nav-item"><a href="{{ route('attendance.index') }}">勤怠一覧</a></li>
                <li class="nav-item"><a href="{{ route('correction.index') }}">申請</a></li>
                <li class="nav-item">
                    <form action="{{ route('staff.logout') }}" method="POST" class="logout-form">
                        @csrf
                        <button type="submit" class="logout-button">ログアウト</button>
                    </form>
                </li>
            </ul>
            @endauth
        </div>
    </header>
    <main>
        @yield('content')
    </main>
</body>