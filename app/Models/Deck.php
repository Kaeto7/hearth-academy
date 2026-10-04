<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Deck extends Model
{
    protected $fillable = ['name', 'class', 'archetype'];

    public function courses()
    {
        return $this->hasMany(Course::class);
    }
}
