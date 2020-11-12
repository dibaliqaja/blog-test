<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'short_description',
        'content',
        'image',
        'thumbnail',
        'category_id',
    ];

    public function category()
    {
        return $this->belongsTo('App\Category');
    }
}
