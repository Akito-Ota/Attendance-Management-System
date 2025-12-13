@extends('layouts.staff')

@section('title', '申請一覧')
{{-----従業員側-----}}

@push('styles')
<link rel="stylesheet" href="{{ asset('css/staff/correction/index.css') }}">
@endpush

@section('content')
<div class="correction-page">
    <div class="correction-container">
        <h1 class="correction-title">申請一覧</h1>

        <div class="tab-container">
            {{-- ラジオボタン --}}
            <input type="radio" id="tab-pending" name="correction-tab" class="tab-input" checked>
            <input type="radio" id="tab-approved" name="correction-tab" class="tab-input">

            {{-- タブメニュー --}}
            <nav class="tab-nav">
                <label for="tab-pending" class="tab-label">承認待ち</label>
                <label for="tab-approved" class="tab-label">承認済み</label>
            </nav>

            {{-- 線引き --}}
            <div class="tab-indicator-line"></div>

            {{-- コンテンツエリア --}}
            <div class="tab-content">

                {{-- パネル1: 承認待ち --}}
                <section class="tab-panel" id="panel-pending">
                    <div class="table-card">
                        <table class="correction-table">
                            <thead>
                                <tr>
                                    <th>状態</th>
                                    <th>名前</th>
                                    <th>対象日時</th>
                                    <th>申請理由</th>
                                    <th>申請日時</th>
                                    <th>詳細</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($pendingCorrections as $day)
                                <tr>
                                    <td>承認待ち</td>
                                    <td>{{ $day->user->name }}</td>
                                    <td>{{ \Carbon\Carbon::parse($day->work_date)->format('Y/m/d') }}</td>
                                    <td>{{ $day->remark }}</td>
                                    <td>{{ \Carbon\Carbon::parse($day->created_at)->format('Y/m/d') }}</td>
                                    <td>
                                        <a href="{{ route('correction.show', $day->id) }}" class="detail-link">詳細</a>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="empty-message">承認待ちの申請はありません</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </section>

                {{-- パネル2: 承認済み --}}
                <section class="tab-panel" id="panel-approved">
                    <div class="table-card">
                        <table class="correction-table">
                            <thead>
                                <tr>
                                    <th>状態</th>
                                    <th>名前</th>
                                    <th>対象日時</th>
                                    <th>申請理由</th>
                                    <th>承認日時</th>
                                    <th>詳細</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($approvedCorrections as $day)
                                <tr>
                                    <td>承認済み</td>
                                    <td>{{ $day->user->name }}</td>
                                    <td>{{ \Carbon\Carbon::parse($day->work_date)->format('Y/m/d') }}</td>
                                    <td>{{ $day->remark }}</td>
                                    <td>{{ optional($day->applied_date)->format('Y/m/d') }}</td>
                                    <td>
                                        <a href="{{ route('correction.show', $day->id) }}" class="detail-link">詳細</a>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="empty-message">承認済みの申請はありません</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </section>

            </div>
        </div>
    </div>
</div>
@endsection