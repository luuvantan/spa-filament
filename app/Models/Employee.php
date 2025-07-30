<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Employee extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'phone', 'cccd', 'birthday', 'email', 'address',
        'branch_id', 'position_id', 'created_by'
    ];

    public function branch() {
        return $this->belongsTo(Branch::class);
    }

    public function position() {
        return $this->belongsTo(Position::class);
    }

    public function creator() {
        return $this->belongsTo(User::class, 'created_by');
    }
}
