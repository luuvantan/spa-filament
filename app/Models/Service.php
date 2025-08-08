<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Service extends Model
{

    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'sessions' => 'integer',
    ];

    public function customerCard(): BelongsTo
    {
        return $this->belongsTo(CustomerCard::class);
    }
}
