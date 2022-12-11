<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BodyInfo extends Model
{
    use HasFactory;

    protected $table = 'body_info';

    /**
     * Relationships
     */

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
