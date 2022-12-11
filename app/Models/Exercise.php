<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Exercise extends Model
{
    use HasFactory;

    const LEVEL = ['beginner', 'advance', 'master'];

    /**
     * Relationships
     */

    public function users()
    {
        return $this->hasManyThrough(User::class, ExerciseHistory::class, 'exercise_id', 'user_id', 'id', 'id');
    }
}
