<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Session extends Model
{
    protected $table = 'class_sessions';

    protected $fillable = [
        'deckmaster_id', 'course_id', 'type',
        'start_at', 'duration', 'capacity',
    ];

    protected $casts = [
        'start_at' => 'datetime',
    ];

    public function deckmaster()
    {
        return $this->belongsTo(User::class, 'deckmaster_id');
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function enrollments()
    {
        return $this->hasMany(Enrollment::class, 'session_id');
    }
}