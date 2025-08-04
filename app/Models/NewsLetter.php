<?php

namespace App\Models;

use App\Enums\MediaType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Notifications\Notifiable;

class NewsLetter extends Model
{
    use Notifiable;

    protected $fillable = [
        'title',
        'week_number',
        'year',
        'pdf_path',
    ];

    protected $casts = [
        'week_number' => 'integer',
        'year' => 'integer',
    ];

    public function getWeekYearAttribute(): string
    {
        return "Tuần {$this->week_number}, {$this->year}";
    }
}
