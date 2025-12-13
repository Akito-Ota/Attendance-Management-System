<?php

namespace Database\Factories;

use App\Models\Rest;
use Illuminate\Database\Eloquent\Factories\Factory;
use Carbon\Carbon;

class RestFactory extends Factory
{
    protected $model = Rest::class;

    public function definition(): array
    {
        $start = Carbon::parse('12:00');
        $end   = Carbon::parse('13:00');

        return [
            'user_id' => 1, 
            'rest_start' => $start,
            'rest_end' => $end,
            'duration_minutes' => $end->diffInMinutes($start),
        ];
    }
}
