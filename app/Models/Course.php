<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Course extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'deckmaster_id', 'deck_id', 'title', 'difficulty',
        'description', 'price', 'status',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'deleted_at' => 'datetime',
    ];

    public function deckmaster()
    {
        return $this->belongsTo(User::class, 'deckmaster_id');
    }

    public function deck()
    {
        return $this->belongsTo(Deck::class);
    }

    public function lessons()
    {
        return $this->hasMany(Lesson::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function purchases()
    {
        return $this->hasMany(Purchase::class);
    }

    public function classSessions()
    {
        return $this->hasMany(Session::class, 'course_id');
    }
}
