@extends('layouts.staff')

@section('title', '勤怠詳細'){{--------スタッフ側＋承認申請もできる---------}}
{{-----従業員側-----}}

@push('styles')
<link rel="stylesheet" href="{{ asset('css/staff/attendance/show.css') }}">
@endpush

@section('content')

@php
$rest1 = $detail->rests[0] ?? null;
$rest2 = $detail->rests[1] ?? null;
@endphp

<div class="attendance_show">
    <div class="attendance_container">

        <h1 class="detail_title">勤怠詳細</h1>

        <div class="attendance_card">
            <form action="{{ route('attendance.update', $detail->id) }}" method="POST">
                @csrf
                @method('PATCH')

                <table class="attendance_table">
                    {{-- 名前 --}}
                    <tr>
                        <th>名前</th>
                        <td class="text_display">{{ $detail->user->name }}</td>
                    </tr>

                    {{-- 日付 --}}
                    <tr>
                        <th>日付</th>
                        <td class="text_display">{{ $detail->work_date->format('Y年n月j日') }}</td>
                    </tr>

                    {{-- 出勤・退勤 --}}
                    <tr>
                        <th>出勤・退勤</th>
                        <td>
                            <div class="time_input_group">
                                <input type="time" name="start_time" class="form_time"
                                    value="{{ old('start_time', $detail->start_time ? $detail->start_time->format('H:i') : '') }}">
                                <span class="tilde">～</span>
                                <input type="time" name="end_time" class="form_time"
                                    value="{{ old('end_time', $detail->end_time ? $detail->end_time->format('H:i') : '') }}">
                            </div>

                            {{-- エラーメッセージ --}}
                            @error('start_time')
                            <div class="form-error">{{ $message }}</div>
                            @enderror
                            @error('end_time')
                            <div class="form-error">{{ $message }}</div>
                            @enderror
                        </td>
                    </tr>

                    {{-- 休憩1 --}}
                    <tr>
                        <th>休憩</th>
                        <td>
                            <div class="time_input_group">
                                <input type="time" name="rest_start" class="form_time"
                                    value="{{ old('rest_start', optional(optional($rest1)->rest_start)->format('H:i')) }}">
                                <span class="tilde">～</span>
                                <input type="time" name="rest_end" class="form_time"
                                    value="{{ old('rest_end', optional(optional($rest1)->rest_end)->format('H:i')) }}">
                            </div>

                            @error('rest_start')
                            <div class="form-error">{{ $message }}</div>
                            @enderror
                            @error('rest_end')
                            <div class="form-error">{{ $message }}</div>
                            @enderror
                        </td>
                    </tr>

                    {{-- 休憩2 --}}
                    <tr>
                        <th>休憩2</th>
                        <td>
                            <div class="time_input_group">
                                <input type="time" name="rest_start2" class="form_time"
                                    value="{{ old('rest_start2', optional(optional($rest2)->rest_start)->format('H:i')) }}">
                                <span class="tilde">～</span>
                                <input type="time" name="rest_end2" class="form_time"
                                    value="{{ old('rest_end2', optional(optional($rest2)->rest_end)->format('H:i')) }}">
                            </div>

                            @error('rest_start2')
                            <div class="form-error">{{ $message }}</div>
                            @enderror
                            @error('rest_end2')
                            <div class="form-error">{{ $message }}</div>
                            @enderror
                        </td>
                    </tr>

                    {{-- 備考 --}}
                    <tr>
                        <th>備考</th>
                        <td>
                            <textarea name="remark" class="form_textarea">{{ old('remark', $detail->remark) }}</textarea>
                            @error('remark')
                            <div class="form-error">{{ $message }}</div>
                            @enderror
                        </td>
                    </tr>
                </table>

                <div class="button_area">
                    <button type="submit" class="submit_btn">修正</button>
                </div>

            </form>
        </div>
    </div>
</div>
@endsection