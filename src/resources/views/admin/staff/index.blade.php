@extends('layouts.admin')

@section('title', 'スタッフ一覧')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/admin/staff/index.css') }}">
@endpush

@section('content')
<div class="staff_index">
    <h1 class="index_title">スタッフ一覧</h1>
    <table class="staff-table">
        <thead>
            <tr>
                <th>名前</th>
                <th>メールアドレス</th>
                <th>月次勤怠</th>
            </tr>
        </thead>
        <tbody>
            @foreach($staff as $user)
            <tr>
                <td>{{ $user->name }}</td>
                <td>{{ $user->email}}</td>
                <td>
                    <a href="{{ route('admin.staff.show', $user->id) }}">詳細</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection