<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\AttendanceCorrectionRequest;
use App\Models\Attendance;
use App\Models\Rest;
use App\Models\Correction;
use Carbon\Carbon;

class CorrectionController extends Controller
{
    public function index()//一覧画面表示
    {
        $pendingCorrections = Correction::with('user')
            ->where('user_id', auth()->id())
            ->where('status', 'pending')
            ->orderBy('created_at', 'desc')
            ->get();

        $approvedCorrections = Correction::with('user')
            ->where('user_id', auth()->id())
            ->where('status', 'approved')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('staff.correction.index', compact('pendingCorrections', 'approvedCorrections'));
    }

    public function show($id)//承認申請をしたものをここに詳細表示するぞ！
    {
        $corrections = Correction::with('user')
            ->where('user_id', auth()->id())
            ->findOrFail($id);
        return view('staff.correction.show', compact('corrections'));
    }
    
    public function update(AttendanceCorrectionRequest $request, $id) //申請機能そのもの
    {
        $data = $request->validated();
        $attendance = Attendance::with('user')
            ->where('user_id', auth()->id())
            ->where('id', $id)
            ->firstOrFail();
        Correction::create([
            'user_id'        => auth()->id(),
            'attendance_id' => $attendance->id,
            'work_date'      => $attendance->work_date,
            'start_time'     => $data['start_time'],
            'end_time'       => $data['end_time'],
            'rest_start'     => $data['rest_start'] ?? null,
            'rest_end'       => $data['rest_end'] ?? null,
            'rest_start2'    => $data['rest_start2'] ?? null,
            'rest_end2'      => $data['rest_end2'] ?? null,
            'remark'         => $data['remark'],
            'status'         => 'pending',
            'applied_date'   => Carbon::now(),
        ]);

        return redirect()
            ->route('attendance.index')
            ->with('status', '勤務情報を申請しました。');
    }
}
