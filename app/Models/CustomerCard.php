<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CustomerCard extends Model
{
    //
    use HasFactory;
    protected $guarded = [];
    protected $casts = [
        'issue_date' => 'date',
        'start_date' => 'date',
        'end_date' => 'date',
    ];

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function card(): BelongsTo
    {
        return $this->belongsTo(Card::class);
    }

//    public function branch(): BelongsTo
//    {
//        return $this->belongsTo(Branch::class);
//    }

    public function services(): HasMany
    {
        return $this->hasMany(Service::class);
    }

}
