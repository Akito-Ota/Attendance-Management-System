@extends('layouts.staff')

@section('title', '出勤一覧')
{{-----従業員側-----}}

@push('styles')
<link rel="stylesheet" href="{{ asset('css/staff/attendance/index.css') }}">
@endpush

@section('content')
<div class="attendance-page">
    <div class="attendance-container">
        <h1 class="attendance-title">勤怠一覧</h1>
        <div class="month-navigation">
            <a href="{{ route('attendance.index', ['year' => $prev->year, 'month' => $prev->month]) }}" class="nav-link prev">&larr; 前月</a>
            <div class="current-month">
                <span class="calendar-icon">🗓️</span>
                {{ $year }}/{{ sprintf('%02d', $month) }}
            </div>
            <a href="{{ route('attendance.index', ['year' => $next->year, 'month' => $next->month]) }}" class="nav-link next">翌月 &rarr;</a>
        </div>
        <div class="table-card">
            <table class="attendance-table">
                <thead>
                    <tr>
                        <th>日付</th>
                        <th>出勤</th>
                        <th>退勤</th>
                        <th>休憩</th>
                        <th>合計</th>
                        <th>詳細</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($dates as $date)
                    @php
                    $attendance = $attendancesByDate[$date->toDateString()] ?? null;
                    @endphp
                    <tr>
                        <td>{{ $date->format('m/d') }}({{ $date->translatedFormat('D') }})</td>
                        <td>{{ optional(optional($attendance)->start_time)->format('H:i') ?? '' }}</td>
                        <td>{{ optional(optional($attendance)->end_time)->format('H:i') ?? '' }}</td>
                        <td>
                            @if($attendance && $attendance->rests->isNotEmpty())
                            {{ gmdate('H:i', $attendance->rests->sum('duration_minutes') * 60) }}
                            @endif
                        </td>
                        <td>{{ $attendance?->total_time_hi }}</td>
                        <td>
                            @if($attendance)
                            <a href="{{ route('attendance.show', $attendance->id) }}" class="detail-link">詳細</a>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

