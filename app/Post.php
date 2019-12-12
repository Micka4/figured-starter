<?php

namespace App;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class Post extends Eloquent
{
    protected $connection = 'mongodb';
    protected $collection = 'posts';

    protected $fillable = ['title', 'body', 'user_id', 'author_name', 'published_at'];

    public function author(): BelongsTo
    {
        return $this->belongsTo('App\User', 'user_id');
    }
}
