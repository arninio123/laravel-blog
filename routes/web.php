<?php

use App\Http\Controllers\CommentController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\SessionsController;
//use App\Models\Category;
//use App\Models\Post;
//use App\Models\User;

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
Route::get('register', [RegisterController::class, 'create'])->middleware('guest');
Route::post('register', [RegisterController::class, 'store'])->middleware('guest');

Route::get('login', [SessionsController::class, 'create'])->middleware('guest');
Route::post('login', [SessionsController::class, 'store'])->middleware('guest');

Route::post('logout', [SessionsController::class, 'destroy'])->middleware('auth');

Route::get('/', [PostController::class, 'index'])->name('home');
Route::get('posts/{post:slug}', [PostController::class, 'show']);
Route::post('posts/{post:slug}/comments', [CommentController::class, 'store']);

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


 // Convert to same route as home
    Route::get('categories/{category}', function (Category $category) {
        return view('posts', [
            'posts' => $category->posts->load(['category', 'author']),
            'currentCategory' => $category,
            'categories' => Category::all()
        ]);
    });


onvert to same route as home
Route::get('authors/{author:username}', function (User $author) {
    return view('posts.index', [
        'posts' => $author->posts->load(['category', 'author']),
    ]);
});

*/



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
| php artisan make:controller PostController
|
|
| php artisan tinker --> to play with db
| App\Models\Post::factory(10)->create(['category_id' => 1])
| App\Models\Post::first()
|
| php artisan db:seed
| php artisan migrate:fresh --seed
| 
| php artisan vendor:publish
*/