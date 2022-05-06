<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    protected $fillable = [
        'name',
        'slug',
    ];

    public function posts()
    {
        return $this->belongsToMany('App\Posts', 'post_tag', 'tags_id', 'posts_id');
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }
}
