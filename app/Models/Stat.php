<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Stat extends Model
{
    protected $fillable = [
        'user_id', 'phase_id', 'score'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function phase()
    {
        return $this->belongsTo(Phase::class);
    }
}
