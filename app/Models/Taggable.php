<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Taggable extends Model
{
    protected $fillable = ['tag_id', 'taggable_id', 'taggable_type'];

    public function taggable()
    {
        return $this->morphTo();
    }

    public function tag()
    {
        return $this->belongsTo(Tag::class);
    }



}
