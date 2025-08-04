<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Card extends Model
{
    //
    protected $fillable = [
        'customer_id',
        'name',
        'type',
        'sessions',
        'hours',
        'minutes',
        'status',
        'issue_date',
        'start_date',
        'end_date',
        'notes',
        'price',
        'commission_per_session',
    ];

    public function customer(): BelongsTo
    {
        // Giả sử model khách hàng của bạn là App\Models\Customer
        return $this->belongsTo(Customer::class);
    }
}
