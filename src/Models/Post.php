<?php

namespace Wave\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Post extends Model
{
    public $guarded = [];

    public function link()
    {
        return url('/blog/' . $this->category->slug . '/' . $this->slug);
    }

    public function user()
    {
        return $this->belongsTo('\Wave\Models\User', 'author_id');
    }

    public function image()
    {
        return Storage::url($this->image);
    }

    public function category()
    {
        return $this->belongsTo('Wave\Models\Category');
    }
}
