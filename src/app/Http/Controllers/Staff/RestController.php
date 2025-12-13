<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Attendance;
use App\Models\Rest;

class RestController extends Controller
{
    public function start(Request $request)
    {

        $attendance = Attendance::where('user_id', auth()->id())
            ->whereDate('start_time', today())
            ->whereNull('end_time')
            ->first();

        Rest::create([
            'user_id'       => auth()->id(),
            'attendance_id' => $attendance->id,
            'rest_start'    => now(),
        ]);

        return redirect()->route('attendance.create');
    }

    public function end(Request $request)
    {
        $rest = Rest::where('user_id', auth()->id())
            ->whereNull('rest_end')
            ->latest('rest_start')
            ->first();

        if (!$rest) {
            return back()->withErrors(['休憩が開始されていません。']);
        }

        $rest->rest_end = now();
        $rest->duration_minutes = $rest->rest_end->diffInMinutes($rest->rest_start);
        $rest->save();
        
        return redirect()->route('attendance.create');
    }
}
