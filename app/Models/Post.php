<?php

namespace App\Models;

use App\Enums\PostStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Notifications\Notifiable;

class Post extends Model
{
    use Notifiable;

    protected $fillable = [
        'title', 'content', 'excerpt', 'category_id', 'author_id',
        'published_at', 'banner_path', 'status', 'language', 'views',
    ];

    protected $casts = [
        'published_at' => 'datetime',
        'status' => PostStatus::class,
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function author()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'post_tags', 'post_id', 'tag_id');
    }

    public function media()
    {
        return $this->hasMany(Media::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function translations()
    {
        return $this->hasMany(PostTranslation::class);
    }

    public function analytics()
    {
        return $this->hasMany(Analytic::class);
    }
}
