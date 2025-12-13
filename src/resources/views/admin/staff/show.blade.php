@extends('layouts.admin')

@section('title', '月次スタッフ別勤怠一覧画面')
{{-----管理者側-----}}

@push('styles')
<link rel="stylesheet" href="{{ asset('css/admin/staff/show.css') }}">
@endpush
@section('content')

<div class="attendance-page">
    <div class="attendance-container">
        <h1 class="attendance-title">{{ $user->name }}さんの勤怠</h1>
        <div class="month-navigation">
            <a href="{{ route('admin.staff.show', ['id' => $user->id,'year' => $prev->year, 'month' => $prev->month]) }}"
                class="nav-link prev">
                &larr; 前月
            </a>
            <div class="current-month">
                <span class="calendar-icon">🗓️</span>
                {{ $year }}/{{ sprintf('%02d', $month) }}
            </div>
            <a href="{{ route('admin.staff.show', ['id' => $user->id,'year' => $next->year, 'month' => $next->month]) }}"
                class="nav-link next">
                翌月 &rarr;
            </a>
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
                        <td>{{ $date->translatedFormat('m/d(D)') }}</td>
                        <td>
                            {{ optional(optional($attendance)->start_time)->format('H:i') }}
                        </td>
                        <td>
                            {{ optional(optional($attendance)->end_time)->format('H:i') }}
                        </td>
                        <td>
                            @if($attendance)
                            {{ $attendance->rest_total_hi }}
                            @endif
                        </td>
                        <td>
                            @if($attendance)
                            {{ $attendance->total_time_hi }}
                            @endif
                        </td>
                        <td>
                            @if($attendance)
                            <a href="{{ route('admin.attendance.show', $attendance->id) }}"
                                class="detail-link">詳細</a>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="csv-export-area">
            <form action="{{ route('admin.staff.csv', $user->id) }}" method="GET" class="csv">
                <button type="submit" class="csv-button">CSV出力</button>
            </form>
        </div>
    </div>
</div>
@endsection