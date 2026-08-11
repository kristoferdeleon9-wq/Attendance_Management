<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Teacher extends Model
{
    protected $fillable = [
        'teacher_id',
        'first_name',
        'last_name',
        'email',
        'department',
        'position',
    ];

    public function classes(): HasMany
    {
        return $this->hasMany(
            SchoolClass::class,
            'teacher_id'
        );
    }
}