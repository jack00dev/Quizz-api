<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Option extends Model
{
    protected $fillable = ['text', 'is_correct', 'question_id'];

    public function question()
    {
        return $this->belongsTo(Question::class);
    }
}
