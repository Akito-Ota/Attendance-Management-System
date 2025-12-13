<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Attendance;
use App\Models\Rest;
use App\Models\Correction;
use Carbon\Carbon;

class CorrectionController extends Controller
{
    public function index(Request $request)//一覧画面
    {
        $pendingCorrections = Correction::with('user')
            ->where('status', 'pending')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        $approvedCorrections =Correction::with('user')
        ->where('status','approved')
        ->orderBy('created_at','desc')
        ->paginate(10);

    return view ('admin.correction.index',compact('pendingCorrections','approvedCorrections'));
    }

    public function show($id)//詳細画面表示
    {
        $corrections = Correction::with('user')
                        ->findOrFail($id);
        return view ('admin.correction.show',compact('corrections'));
    }


    public function approve($id)
    {
        $correction = Correction::with('user')->findOrFail($id);

        $attendance = Attendance::with('rests')->findOrFail($correction->attendance_id);

        $attendance->start_time = $correction->start_time;
        $attendance->end_time   = $correction->end_time;
        $attendance->remark     = $correction->remark;

        $attendance->rests()->delete();

        if (!empty($correction->rest_start) && !empty($correction->rest_end)) {

            $start = Carbon::parse($correction->rest_start);
            $end   = Carbon::parse($correction->rest_end);

            $duration = $end->diffInMinutes($start);

            Rest::create([
                'user_id'         => $attendance->user_id,
                'attendance_id'   => $attendance->id,
                'rest_start'      => $correction->rest_start,
                'rest_end'        => $correction->rest_end,
                'duration_minutes' => $duration,
            ]);
        }

        // ★ 休憩2
        if (!empty($correction->rest_start2) && !empty($correction->rest_end2)) {

            $start2 = Carbon::parse($correction->rest_start2);
            $end2   = Carbon::parse($correction->rest_end2);

            $duration2 = $end2->diffInMinutes($start2);

            Rest::create([
                'user_id'         => $attendance->user_id,
                'attendance_id'   => $attendance->id,
                'rest_start'      => $correction->rest_start2,
                'rest_end'        => $correction->rest_end2,
                'duration_minutes' => $duration2,
            ]);
        }

        $attendance->load('rests');

        $totalRestMinutes = $attendance->rests->sum('duration_minutes');

        $stayMinutes = $attendance->end_time->diffInMinutes($attendance->start_time);

        $attendance->total_time = $stayMinutes - $totalRestMinutes;
        $attendance->save();

        $correction->status       = 'approved';
        $correction->applied_date = Carbon::today();
        $correction->save();

        return redirect()
            ->route('admin.correction.show',$id)
            ->with('status', '申請を承認しました。');
    }
}