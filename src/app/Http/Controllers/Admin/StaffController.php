<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Attendance;
use App\Models\Correction;
use Carbon\Carbon;
use Carbon\CarbonPeriod;

class StaffController extends Controller //スタッフ一覧表示
{
    public function index()
    {
        $staff = User::where('role', '!=', 'admin')->paginate(10);

        return view ('admin.staff.index',compact('staff'));
    }

    public function show(Request $request, $id)
    {
        $year   = (int)($request->year  ?? now()->year);
        $month  = (int)($request->month ?? now()->month);

        $target = Carbon::create($year, $month, 1);
        $prev   = $target->copy()->subMonth();
        $next   = $target->copy()->addMonth();

        $start  = Carbon::create($year, $month, 1)->startOfMonth();
        $end    = Carbon::create($year, $month, 1)->endOfMonth();

        $dates = CarbonPeriod::create($start, $end)->toArray();

        $user = User::findOrFail($id);

        $attendances = Attendance::with(['user', 'rests'])
            ->where('user_id', $id)
            ->whereBetween('work_date', [$start, $end])
            ->orderBy('work_date')
            ->get();

        $attendancesByDate = $attendances->keyBy(
            fn($attendance) => $attendance->work_date->toDateString()
        );

        return view('admin.staff.show', compact(
            'year',
            'month',
            'start',
            'end',
            'target',
            'prev',
            'next',
            'user',
            'dates',            
            'attendancesByDate'   
        ));
    }
}
