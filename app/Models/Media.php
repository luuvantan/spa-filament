<?php

namespace App\Models;

use App\Enums\MediaType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Notifications\Notifiable;

class Media extends Model
{
    use Notifiable;

    protected $fillable = ['url', 'type', 'post_id'];

    protected $casts = [
        'type' => MediaType::class,
    ];

    public function post()
    {
        return $this->belongsTo(Post::class);
    }
}
