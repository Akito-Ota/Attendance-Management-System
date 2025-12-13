@extends('layouts.staff')

@section('title', '各種打刻')
{{-----従業員側-----}}

@push('styles')
<link rel="stylesheet" href="{{ asset('css/attendance.css') }}">
@endpush

@section('content')
<div class="attendance-page">
    <div class="attendance-container">
        <div class="status-badge">
            @if ($status === 'before_work')
            <span class="status-text">勤務外</span>
            @elseif ($status === 'working')
            <span class="status-text">勤務中</span>
            @elseif ($status === 'rest')
            <span class="status-text">休憩中</span>
            @else
            <span class="status-text">退勤済</span>
            @endif
        </div>

        <div class="attendance-date">
            {{ $now->translatedFormat('Y年n月j日 (D)') }}
        </div>

        <div class="attendance-time">
            <div id="clock">
                {{ $now->format('H:i') }}
            </div>
        </div>

        <div class="attendance-buttons">
            @if ($status === 'before_work')
            <form action="{{ route('attendance.clockin') }}" method="POST">
                @csrf
                <button type="submit" class="btn-main">出勤</button>
            </form>

            @elseif ($status === 'working')
            <form action="{{ route('attendance.clockout') }}" method="POST">
                @csrf
                <button type="submit" class="btn-main">退勤</button>
            </form>
            <form action="{{ route('rest.start') }}" method="POST">
                @csrf
                <button type="submit" class="btn-sub">休憩入</button>
            </form>

            @elseif ($status === 'rest')
            <form action="{{ route('rest.end') }}" method="POST">
                @csrf
                <button type="submit" class="btn-sub">休憩戻</button>
            </form>

            @else
            <p class="attendance-message">お疲れ様でした</p>
            @endif
        </div>
    </div>
</div>

<script>
    function updateClock() {
        const now = new Date();

        const hours = String(now.getHours()).padStart(2, '0');
        const minutes = String(now.getMinutes()).padStart(2, '0');

        const timeString = `${hours}:${minutes}`;

        document.getElementById('clock').textContent = timeString;
    }
    setInterval(updateClock, 1000);

    updateClock();
</script>
@endsection