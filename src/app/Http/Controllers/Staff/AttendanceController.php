<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\AttendanceCorrectionRequest;
use App\Models\User;
use App\Models\Attendance;
use App\Models\Rest;
use App\Models\Correction;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Carbon\CarbonPeriod;

class AttendanceController extends Controller
{
    public function create() //勤怠登録画面
    {
        $todayAttendance = Attendance::where('user_id', auth()->id())
            ->whereDate('work_date', today())  
            ->latest('start_time')             
            ->first();

        $status = 'before_work';

        $todayRest = null;

        if ($todayAttendance) {
            if (is_null($todayAttendance->end_time)) {
                $status = 'working';    
            } else {
                $status = 'after_work'; 
            }
        }
        if ($status === 'working') {
            $todayRest = Rest::where('attendance_id', $todayAttendance->id)
                ->whereNull('rest_end')     
                ->first();
            if ($todayRest) {
                $status = 'rest';         
            }
        }

        $now = now();

        $weekday = $now->isoFormat('dddd');

        return view('staff.attendance', compact('status', 'now', 'weekday'));
    }


    public function index(Request $request)//出勤一覧画面
    {
        $year = (int) ($request->year ?? now()->year);
        $month = (int) ($request->month ?? now()->month);

        $target = Carbon::create($year, $month, 1);

        $prev = $target->copy()->subMonth();
        $next = $target->copy()->addMonth();

        $start = Carbon::create($year, $month, 1)->startOfMonth();
        $end = Carbon::create($year, $month, 1)->endOfMonth();

        $dates = CarbonPeriod::create($start, $end)->toArray();

        $attendances = Attendance::where('user_id', auth()->id())
            ->whereBetween('work_date', [$start, $end])
            ->with('rests')
            ->orderBy('work_date')
            ->get();
        $attendancesByDate = $attendances->keyBy(
            fn($attendance) => $attendance->work_date->toDateString()
        );
        return view('staff.attendance.index', compact('attendancesByDate', 'attendances', 'year', 'month','start','end','target','prev','next','dates'));
    }

    public function createclockin(Request $request)//出勤登録
    {
        $data = $request->all();
        Attendance::create(
            [
                'user_id'  => auth()->id(),
                'start_time' => Carbon::now(),
                'work_date'  => Carbon::today(),
            ]
        );

        return redirect()->route('attendance.create');
    }

    public function createclockout(Request $request) //退勤登録
    {
        $attendance = Attendance::where('user_id', auth()->id())
            ->whereDate('start_time', today())
            ->whereNull('end_time')
            ->first();

        if (!$attendance) {
            return back()->withErrors(['msg' => '本日の出勤記録がありません。']);
        }

        if (!$attendance) {
            return back()->withErrors([
                'attendance' => '退勤できる出勤記録がありません。',
            ]);
        }
        $attendance->end_time = Carbon::now();

        $attendance->total_time = $attendance->end_time->diffInMinutes($attendance->start_time);

        $attendance->save();

        return redirect()->route('attendance.create');
    }

    public function show($id) //勤怠詳細画面に遷移する
    {
        $detail = Attendance::with(['user', 'rests'])
            ->where('user_id', auth()->id())
            ->findOrFail($id);
        return view('staff.attendance.show', compact('detail'));
    }
}