<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    protected $fillable = ['user_id','phase_id','theme_id', 'question_id', 'option_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function phase()
    {
        return $this->belongsTo(Phase::class);
    }
    public function theme()
    {
        return $this->belongsTo(Theme::class);
    }
    public function question()
    {
        return $this->belongsTo(Question::class);
    }

    public function option()
    {
        return $this->belongsTo(Option::class);
    }
}
