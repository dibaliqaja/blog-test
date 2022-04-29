<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
    protected $guarded = [];

    public function posts()
    {
        return $this->belongsTo('App\Post');
    }

    public function users()
    {
        return $this->belongsTo('App\User');
    }
}
