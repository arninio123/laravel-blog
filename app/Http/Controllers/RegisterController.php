<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class RegisterController extends Controller
{
    public function create(){
        return view('register.create');
    }

    public function store(){
        $attributes = request()->validate([
            'name' => 'required|max:255',
            'username' => 'required|max:255|min:3|unique:users,username',
            'email' => ['required', 'max:255', 'email', Rule::unique('users'), 'email' ],
            'password' => ['required', 'max:255', 'min:7']
        ]);

        //$attributes['password'] = bcrypt($attributes['password']);
        

        $user = User::create($attributes); //Password word nugeEncrypt in UserModel met Set<name>Attribute

        /*
        User::create([
            'name' => $attributes['name'],
            'username' => $attributes['username'],
            'email' => $attributes['email'],
            'password' => bcrypt($attributes['password'])
        ]);
        */

        //session()->flash('success', 'Your account has been created.');

        auth()->login($user);

        return redirect('/')->with('success', 'Your account has been created.');
    }
}
