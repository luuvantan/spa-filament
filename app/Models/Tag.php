<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;

class Tag extends Model
{
    use Notifiable;

    protected $fillable = ['name', 'slug'];

    public static function booted()
    {
        static::saving(function ($tag) {
            $tag->slug = Str::slug($tag->name);
        });
    }


    public function posts()
    {
        return $this->belongsToMany(Post::class, 'post_tags', 'tag_id', 'post_id');
    }
}
