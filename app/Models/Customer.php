<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Customer extends Model
{
    protected $fillable = [
        'name',
        'phone',
        'email',
        'birthday',
        'gender',
        'note',
        'visit_count',
        'address',
        'hometown',
        'customer_type',
        'city',
        'district',
        'ward',
        'rank'
    ];

    protected $casts = [

    ];
    public function payments()
    {
        return $this->hasMany(Payment::class);
    }
    public function cards()
    {
        return $this->hasMany(Card::class);
    }

    public function customerCards(): HasMany {
        return $this->hasMany(CustomerCard::class);
    }
}
