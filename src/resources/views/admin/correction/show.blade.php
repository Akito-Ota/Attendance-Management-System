@extends('layouts.admin')

@section('title', '修正申請承認画面')

{{-----管理者側-----}}

@push('styles')
<link rel="stylesheet" href="{{ asset('css/admin/correction/show.css') }}">
@endpush

@section('content')

@php
$rest1 = $detail->rests[0] ?? null;
$rest2 = $detail->rests[1] ?? null;
@endphp

<div class="attendance_show">
    <div class="attendance_container">
        <h1 class="detail_title">勤怠詳細</h1>

        <form action="{{ route('admin.correction.approve', $corrections->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="attendance_card">
                <table class="attendance_table">
                    {{-- 名前 --}}
                    <tr>
                        <th>名前</th>
                        <td class="text_display">{{ $corrections->user->name }}</td>
                    </tr>

                    {{-- 日付 --}}
                    <tr>
                        <th>日付</th>
                        <td class="text_display">
                            {{ $corrections->work_date }}
                        </td>
                    </tr>

                    {{-- 出勤・退勤 --}}
                    <tr>
                        <th>出勤・退勤</th>
                        <td>
                            <div class="time_input_group">
                                <span class="text_display">
                                    {{ $corrections->start_time?->format('H:i') ?? '' }}
                                </span>
                                <span class="title">〜</span>
                                <span class="text_display">
                                    {{ $corrections->end_time?->format('H:i') ?? '' }}
                                </span>
                            </div>
                        </td>
                    </tr>

                    {{-- 休憩 --}}
                    <tr>
                        <th>休憩</th>
                        <td>
                            <div class="time_input_group">
                                <span class="text_display">
                                    {{ $corrections->rest_start?->format('H:i') ?? '' }}
                                </span>
                                <span class="title">〜</span>
                                <span class="text_display">
                                    {{ $corrections->rest_end?->format('H:i') ?? '' }}
                                </span>
                            </div>
                        </td>
                    </tr>

                    {{-- 休憩2 --}}
                    <tr>
                        <th>休憩2</th>
                        <td>
                            <div class="time_input_group">
                                <span class="text_display">
                                    {{ $corrections->rest_start2?->format('H:i') ?? '' }}
                                </span>
                                <span class="title">〜</span>
                                <span class="text_display">
                                    {{ $corrections->rest_end2?->format('H:i') ?? '' }}
                                </span>
                            </div>
                        </td>
                    </tr>

                    {{-- 備考 --}}
                    <tr>
                        <th>備考</th>
                        <td class="text_display">{{ $corrections->remark }}</td>
                    </tr>
                </table>
            </div>

            {{-- 申請ステータス＆ボタン（管理者：承認） --}}
            <div class="button_area">
                @if ($corrections->status === 'pending')
                <button type="submit" class="submit_btn">承認</button>
                @else
                <button type="button" class="submit_btn" disabled>承認済み</button>
                @endif
            </div>
        </form>
    </div>
</div>
@endsection