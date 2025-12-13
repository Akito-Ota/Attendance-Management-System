<?php

namespace Database\Factories;

use App\Models\Attendance;
use Illuminate\Database\Eloquent\Factories\Factory;
use Carbon\Carbon;

class AttendanceFactory extends Factory
{
    protected $model = Attendance::class;

    public function definition(): array
    {
        $workDate = Carbon::today();
        $start = Carbon::parse($workDate->toDateString() . ' 09:00');
        $end   = Carbon::parse($workDate->toDateString() . ' 18:00');

        return [
            'user_id' => 1, 
            'work_date' => $workDate->toDateString(),
            'start_time' => $start,
            'end_time' => $end,
            'total_time' => null, 
            'remark' => '電車遅延のため',
        ];
    }
}