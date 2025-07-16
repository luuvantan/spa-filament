<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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
    ];

    protected $casts = [
        
    ];    
}
