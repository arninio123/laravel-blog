<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    //Mitigate Mass assaignment Vulnerabilities
    //protected $guarded = [];
    //protected $fillable = ['title', 'slug', 'body', 'category'];

    //Alway load posts with their
    //protected $with = ['category', 'author'];
    //Post::without('author')->first()

    public function category()
    {
        // 1 post belongs to 1 category
        // hasOne, hasMany, --> BelongsTo, BelongsToMany
        return $this->belongsTo(Category::class);
    }

    /*
    public function user()
    {
        // 1 post belongs to 1 user
        // hasOne, hasMany, --> BelongsTo, BelongsToMany
        return $this->belongsTo(User::class);
    }
    */

    public function author() //will search for author_id as foreign key 
    {
        // 1 post belongs to 1 user
        // hasOne, hasMany, --> BelongsTo, BelongsToMany
        return $this->belongsTo(User::class, 'user_id');
    }

}
