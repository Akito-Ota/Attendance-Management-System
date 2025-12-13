@extends('layouts.admin')

@section('title', 'その日の出勤一覧')
{{-----管理者側-----}}

@push('styles')
<link rel="stylesheet" href="{{ asset('css/admin/attendance/index.css') }}">
@endpush

@section('content')
<div class="attendance-page">

    <div class="page-header">
        <h1 class="page-title">{{ $now->translatedFormat('Y年n月j日') }}の勤怠</h1>
    </div>

    <div class="date-navigation">
        <a href="{{ route('admin.attendance.index', ['date' => $prevDate->toDateString()]) }}" class="nav-btn prev">
            &larr; 前日
        </a>

        <div class="current-date-display">
            <span class="calendar-icon">🗓️</span> {{ $now->format('Y/m/d') }}
        </div>

        <a href="{{ route('admin.attendance.index', ['date' => $nextDate->toDateString()]) }}" class="nav-btn next">
            翌日 &rarr;
        </a>
    </div>

    <div class="table-container">
        <table class="attendance-table">
            <thead>
                <tr>
                    <th>名前</th>
                    <th>出勤</th>
                    <th>退勤</th>
                    <th>休憩</th>
                    <th>合計</th>
                    <th>詳細</th>
                </tr>
            </thead>
            <tbody>
                @foreach($attendances as $day)
                <tr>
                    <td>{{ $day->user->name }}</td>
                    <td>{{ optional($day->start_time)->format('H:i') }}</td>
                    <td>{{ optional($day->end_time)->format('H:i') }}</td>
                    <td>{{ $day->rest_total_hi }}</td>
                    <td>{{ $day->total_time_hi }}</td>
                    <td>
                        <a href="{{ route('admin.attendance.show', $day->id) }}" class="detail-link">詳細</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection