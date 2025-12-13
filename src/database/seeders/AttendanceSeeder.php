<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Attendance;
use App\Models\Rest;
use App\Models\User;
use Carbon\Carbon;
use Carbon\CarbonPeriod;

class AttendanceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::where('email', 'test@example.com')->first();
        $userId = $user->id;
        $from = Carbon::today()->subMonths(2)->startOfMonth();
        $to = Carbon::today()->endOfMonth();

        foreach(CarbonPeriod::create($from,$to)as $date){
            
            if($date->isWeekend()){
                continue;
            }

            $start = Carbon::parse($date->toDateString().'9:00');
            $isToday = $date->isToday();   


            $end = Carbon::parse($date->toDateString().'18:00');

            $attendance =Attendance::factory()->create([
                'user_id' =>$userId,
                'work_date' =>$date->toDateString(),
                'start_time'=>$start,
                'end_time' => $isToday ? null : $end,

            ]);

                $totalRest = 0;

                $rStart = Carbon::parse($date->toDateString() . ' 12:00');
                $rEnd   = Carbon::parse($date->toDateString() . ' 13:00');

                Rest::factory()->create([
                    'user_id' => $userId,
                    'attendance_id' => $attendance->id,
                    'rest_start' => $rStart,
                    'rest_end' => $rEnd,
                    'duration_minutes' => $rEnd->diffInMinutes($rStart),
                ]);

                $totalRest += $rEnd->diffInMinutes($rStart);
        
            
            $stay = $end->diffInMinutes($start);
            $attendance->total_time = $stay - $totalRest;
            $attendance->save();
        }
    }
}
