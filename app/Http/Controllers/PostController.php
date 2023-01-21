<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index(){
        return view('posts.index', [
            'posts' => Post::latest()
                ->with('category', 'author')
                ->filter(request(['search', 'category', 'author']))
                ->paginate(6)
                ->withQueryString(),
        ]);

        /*
            OLD query 
            N+1 problem
            'posts' => Post::all() Will do the following queries behind the scenes
            Post	    SELECT * FROM `posts`
            Category	SELECT * FROM `categories` WHERE `categories`.`id` = 1 LIMIT 1
            Category    SELECT * FROM `categories` WHERE `categories`.`id` = 1 LIMIT 1
            Category	SELECT * FROM `categories` WHERE `categories`.`id` = 3 LIMIT 1

            New query
                'posts' => Post::with('category')->get()
                Post	    SELECT * FROM `posts`
                Category	SELECT * FROM `categories` WHERE `categories`.`id` in (1, 3)
        */
    }

    public function show(Post $post){
        return view('posts.show', [
            'post' => $post
        ]);
    }
}
