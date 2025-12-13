<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\User;
use App\Models\Attendance;

class Correction extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'attendance_id',
        'work_date',
        'start_time',
        'end_time',
        'rest_start',
        'rest_end',
        'rest_start2',
        'rest_end2',
        'remark',
        'status',
        'applied_date',
    ];

    protected $casts = [
        'start_time' => 'datetime',
        'end_time' => 'datetime',
        'rest_start' => 'datetime',
        'rest_end' => 'datetime',
        'rest_start2' => 'datetime',
        'rest_end2' => 'datetime',
        'work_date' => 'datetime',
        'applied_date'=>'datetime',
    ];

    public function attendance()
    {
        return $this->belongsTo(Attendance::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
