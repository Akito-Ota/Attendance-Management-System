<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\User;
use App\Models\Rest;
use App\Models\Correction;

class Attendance extends Model
{
    use HasFactory;

    protected $fillable = [
    'user_id',
    'start_time',
    'end_time',
    'total_time',
    'remark',
    'work_date',
    ];

    protected $casts = [
        'start_time' => 'datetime',
        'end_time' => 'datetime',
        'work_date'=> 'datetime',
    ];


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function rests()
    {
        return $this->hasMany(Rest::class);
    }

    public function corrections()
    {
        return $this->hasMany(Correction::class);
    }

    public function getTotalTimeHiAttribute()
    {
        if ($this->total_time === null) {
            return null;
        }

        return sprintf('%d:%02d', intdiv($this->total_time, 60), $this->total_time % 60);
    }
    public function getRestTotalHiAttribute()
    {
        $m = $this->rests->sum('duration_minutes');
        return sprintf('%d:%02d', intdiv($m, 60), $m % 60);
    }
}