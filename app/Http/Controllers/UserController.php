<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(){
        $users =  User::orderBy('created_at', 'desc')->paginate(50);
        return view('users.index')->with('users', $users);
    }

    public function create(){
        return view('auth.register');
    }
}
