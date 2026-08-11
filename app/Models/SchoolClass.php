<?php

namespace App\Models;

use App\Models\Section;
use App\Models\Teacher;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SchoolClass extends Model
{
    protected $table = 'classes';

    protected $fillable = [
        'class_name',
        'subject',
        'section_id',
        'schedule',
        'room',
        'description',
        'teacher_id',
    ];

    public function teacher(): BelongsTo
    {
        return $this->belongsTo(Teacher::class);
    }

    public function section()
    {
        return $this->belongsTo(Section::class);
    }

    public function students(): BelongsToMany
    {
        return $this->belongsToMany(
            Student::class,
            'class_student',
            'class_id',
            'student_id'
        );
    }

    public function attendances(): HasMany
    {
        return $this->hasMany(
            Attendance::class,
            'class_id'
        );
    }
    
    public function attendanceSessions(): HasMany
    {
        return $this->hasMany(
            AttendanceSession::class,
            'class_id'
        );
    }

    
}