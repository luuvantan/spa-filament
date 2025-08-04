<?php

namespace App\Models;

use App\Enums\AnalyticAction;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Notifications\Notifiable;

class Analytic extends Model
{
    use Notifiable;

    protected $fillable = ['post_id', 'user_id', 'action'];

    protected $casts = [
        'action' => AnalyticAction::class,
    ];

    public function post()
    {
        return $this->belongsTo(Post::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
