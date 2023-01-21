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

    // Accepteert een query en dan kan je de functie filter er op gebruiken (Post::newQuery()->filter()->get())
    public function scopeFilter($query, array $filters){ 
        
        $query->when($filters['search'] ?? false, fn($query, $search) => 
            $query->where(fn($query) =>
                $query->where('title', 'like', '%' . $filters['search'] . '%')
                ->orWhere('body', 'like', '%' . $filters['search'] . '%')
            )
        );

        /* 
            if($filters['search'] ?? false){
            $query
                ->where('title', 'like', '%' . $filters['search'] . '%')
                ->orWhere('body', 'like', '%' . $filters['search'] . '%');
            }

            is het zelfde als hier boven maar dan arrow function
            $query->when($filters['search'] ?? false), fn($query, $search) => $query
                ->where('title', 'like', '%' . $filters['search'] . '%')
                ->orWhere('body', 'like', '%' . $filters['search'] . '%');
        */

        $query->when($filters['category'] ?? false, fn($query, $category) =>
            $query->whereHas('category', fn ($query) =>
                $query->where('id', $category)
            )
        );

        $query->when($filters['author'] ?? false, fn($query, $author) =>
            $query->whereHas('author', fn ($query) =>
                $query->where('username', $author)
            )
        );
    }

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

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

}
