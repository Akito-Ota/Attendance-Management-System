<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Attendance;
use App\Models\Correction;
use App\Models\Rest;
use App\Http\Requests\AttendanceCorrectionRequest;

class AttendanceController extends Controller //その日の出勤一覧
{
    public function index(Request $request)
    {

        $dateString = $request->query('date');

        $targetDate = $dateString
            ? Carbon::parse($dateString)
            : Carbon::today();


        $prevDate = $targetDate->copy()->subDay();
        $nextDate = $targetDate->copy()->addDay();

        $attendances = Attendance::with('user', 'rests')
            ->whereDate('work_date', $targetDate->format('Y-m-d'))
            ->orderBy('user_id')
            ->get();
        $now = $request->date
            ? Carbon::parse($request->date)
            : Carbon::today();

        $prevDate = $now->copy()->subDay();
        $nextDate = $now->copy()->addDay();

        $weekday = $now->isoFormat('dddd');
        return view('admin.attendance.index', compact('attendances','targetDate','prevDate','nextDate','dateString','now','weekday',
            'prevDate','nextDate'));
    }

    public function show($id) //詳細画面に遷移・表示
    {
        $detail = Attendance::with('user','rests')
                    ->findOrFail($id);
        return view ('admin.attendance.show',compact('detail'));
    }


    public function update(AttendanceCorrectionRequest $request, $id)
    {
        $data = $request->validated();

        $attendance = Attendance::with('rests')->findOrFail($id); //ここでデータ取得

        $attendance->start_time = $data['start_time'];
        $attendance->end_time   = $data['end_time'];
        $attendance->remark     = $data['remark']; //ここで時間を修正、記録

        $attendance->rests()->delete();

        // ★ 休憩1
        if (!empty($data['rest_start']) && !empty($data['rest_end'])) {

            $start = Carbon::createFromFormat('H:i', $data['rest_start']);
            $end   = Carbon::createFromFormat('H:i', $data['rest_end']);

            $duration = $end->diffInMinutes($start);

            Rest::create([
                'user_id'        => $attendance->user_id,
                'attendance_id'  => $attendance->id,
                'rest_start'     => $data['rest_start'],
                'rest_end'       => $data['rest_end'],
                'duration_minutes' => $duration,   // ← ここに1回分の休憩時間
            ]);
        }

        // ★ 休憩2
        if (!empty($data['rest_start2']) && !empty($data['rest_end2'])) {

            $start2 = Carbon::createFromFormat('H:i', $data['rest_start2']);
            $end2   = Carbon::createFromFormat('H:i', $data['rest_end2']);

            $duration2 = $end2->diffInMinutes($start2);

            Rest::create([
                'user_id'        => $attendance->user_id,
                'attendance_id'  => $attendance->id,
                'rest_start'     => $data['rest_start2'],
                'rest_end'       => $data['rest_end2'],
                'duration_minutes' => $duration2,
            ]);
        }


        $attendance->load('rests');

        $totalRestMinutes = $attendance->rests->sum('duration_minutes');

        $stayMinutes = $attendance->end_time->diffInMinutes($attendance->start_time);

        $attendance->total_time = $stayMinutes - $totalRestMinutes;

        $attendance->save();

        return redirect()
            ->route('admin.attendance.index')
            ->with('status', '勤怠を修正しました。');
    }
}

