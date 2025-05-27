<?php

namespace App\Models;

use App\Cache\PostCache;
use App\Enum\PostStatus;
use App\Media\HasMedia;
use App\Media\Mediable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Cache;

class Post extends Model implements Mediable
{
    /** @use HasFactory<\Database\Factories\PostFactory> */
    use HasFactory, SoftDeletes,HasMedia;

    public $fillable = [
        'title',
        'user_id',
        'content',
        'status',
        'published_at',
        'thumbnail'
    ];
    protected $appends = ['status_name','status_color'];
    public function cast()
    {
        return [
            'published_at' => 'datetime',
            'status' => PostStatus::class,
        ];
    }

    public function setTitleAttribute($value)
    {
        $this->attributes['title'] = strtolower($value);

        $slugBase = str_replace(' ', '-', $this->attributes['title']);
        $slug = $slugBase;
        $count = 1;
        while (self::where('slug', $slug)->exists()) {
            $slug = $slugBase . '-' . $count++;
        }
        $this->attributes['slug'] = $slug;
    }




    public function setThumbnailAttribute($file)
    {
        if ($file) {
            if ($this->media()->where('collection_name', 'thumbnail')->first()) {
                $this->deleteMedia($this->media()->where('collection_name', 'thumbnail')->first()->id);
            }
            $this->addMedia($file, 'thumbnail', ['tags' => '']);
        }
    }

    public function getThumbnailAttribute()
    {
        return $this->getFirstUrl('thumbnail');
    }


    public function getStatusNameAttribute()
    {
        return PostStatus::find($this->status);
    }

    public function getStatusColorAttribute()
    {
        return PostStatus::color($this->status);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }


    public function tags()
    {
        return $this->morphToMany(Tag::class, 'taggable');
    }

    public static function boot()
    {
        parent::boot();

        static::deleting(function ($post) {
            $post->deleteImage();
            $post->clearMediaCollection('thumbnail');
        });

        $clearCache = function () {
            (new PostCache())->clearAllPostsCache();

        };

        static::saved($clearCache);
        static::updated($clearCache);
        static::deleted($clearCache);
    }

}
