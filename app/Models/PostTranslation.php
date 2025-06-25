<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Notifications\Notifiable;

class PostTranslation extends Model
{
    use Notifiable;

    protected $fillable = ['post_id', 'language', 'title', 'content', 'excerpt'];

    public function post()
    {
        return $this->belongsTo(Post::class);
    }
}
