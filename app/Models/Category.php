<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    public function posts()
    {   
        // A Category has many posts
        // hasOne, --> hasMany, BelongsTo, BelongsToMany
        return $this->hasMany(Post::class);
    }
}
