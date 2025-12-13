<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Attendance;
use App\Models\Correction;
use App\Models\Rest;
use Carbon\Carbon;
class CsvDownloadController extends Controller
{
    public function export($id)
    {
        $year = $request->year ?? now()->year;
        $month = $request->month ?? now()->month;
        $start = Carbon::create($year, $month, 1)->startOfMonth();
        $end   = Carbon::create($year, $month, 1)->endOfMonth();

        $fileName = "attendance_{$year}_{$month}.csv";

        $attendances = Attendance::with(['user', 'rests'])
            ->where('user_id', $id)
            ->whereBetween('work_date', [$start, $end])
            ->orderBy('work_date')
            ->get();

        return response()->streamDownload(function () use ($attendances) {
            $stream = fopen('php://output', 'w');

            fwrite($stream, pack('C*', 0xEF, 0xBB, 0xBF));

            fputcsv($stream, ['名前', '日付', '出勤', '退勤', '休憩(分)', '合計', '備考']);

            foreach ($attendances as $attendance) {
                $restMinutes = $attendance->rests->sum('duration_minutes');

                fputcsv($stream, [
                    $attendance->user->name,
                    optional($attendance->work_date)->format('Y-m-d'),
                    optional($attendance->start_time)->format('H:i'),
                    optional($attendance->end_time)->format('H:i'),
                    $restMinutes,
                    $attendance->total_time,
                    $attendance->remark,
                ]);
            }

            fclose($stream);
        }, $fileName);
    }
}
