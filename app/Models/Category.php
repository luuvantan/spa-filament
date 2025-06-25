<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Category extends Model
{
    protected $table = 'categories';

    protected $fillable = ['name', 'slug', 'parent_id', 'description'];

    public static function booted()
    {
        static::saving(function ($category) {
            $category->slug = Str::slug($category->name);
        });
    }

    public function parent()
    {
        return $this->belongsTo(__CLASS__, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(__CLASS__, 'parent_id');
    }

    public function posts()
    {
        return $this->hasMany(Post::class);
    }
}
