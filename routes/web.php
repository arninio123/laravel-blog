<?php

use App\Models\Category;
use App\Models\Post;
use App\Models\User;

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('posts', [
        //'posts' => Post::all()
        'posts' => Post::latest()->with('category', 'author')->get(),
        'categories' => Category::all()
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

})->name('home');

/*

    Route::get('posts/{post}', function ($id) {
        return view('post', [
            'post' => Post::findOrFail($id)
        ]);
    });

    Route::get('posts/{post}', function (Post $post) { //Post::find('id', $post) //zoekt standaard naar id, kan aangepast worden door getRouteKeyName toe tevoegen aan Model
        return view('post', [
            'post' => $post
        ]);
    });

*/

Route::get('posts/{post:slug}', function (Post $post) { //Post::where('slug', $post)->firstOrFail()
    return view('post', [
        'post' => $post
    ]);
});

Route::get('categories/{category}', function (Category $category) {
    return view('posts', [
        'posts' => $category->posts->load(['category', 'author']),
        'currentCategory' => $category,
        'categories' => Category::all()
    ]);
});

Route::get('authors/{author:username}', function (User $author) {
    return view('posts', [
        'posts' => $author->posts->load(['category', 'author']),
        'categories' => Category::all()
    ]);
});



/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
| php artisan help ... (migrate, db:seed, make:model...)
|    
| php artisan migrate
| php artisan migrate:rollback
| php artisan migrate:fresh
| 
| php artisan make:model post
| php artisan make:migration create_posts_table
| php artisan make:model post -m
| php artisan make:factory PostFactory
| php artisan make:model Post -mf
|
| php artisan tinker --> to play with db
| App\Models\Post::factory(10)->create(['category_id' => 1])
| App\Models\Post::first()
|
| php artisan db:seed
| php artisan migrate:fresh --seed
|
| 
*/