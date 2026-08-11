<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AttendanceSession extends Model
{
    protected $fillable = [
        'class_id',
        'attendance_date',
        'started_at',
        'ended_at',
        'status',
    ];

    protected $casts = [
        'attendance_date' => 'date',
        'started_at' => 'datetime',
        'ended_at' => 'datetime',
    ];

    public function schoolClass(): BelongsTo
    {
        return $this->belongsTo(
            SchoolClass::class,
            'class_id'
        );
    }

    public function isOpen(): bool
    {
        return $this->status === 'open';
    }
}