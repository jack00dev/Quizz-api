<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    protected $fillable = ['content', 'theme_id'];

    public function theme()
    {
        return $this->belongsTo(Theme::class);
    }

    public function options()
    {
        return $this->hasMany(Option::class);
    }
}
