<?php

namespace App\Http\Controllers;

use App\Rules\ValidateUsername;
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

    public function edit($id){
        $user = User::find($id);
        return view('users.edit')->with('user', $user);
    }

    public function update(Request $request, $id){
        $this->validate($request, [
            'username' => ['required', new ValidateUsername($id)],
            'name' => 'required',
            'role' => 'required',
            'password' => 'sometimes|nullable|min:6|confirmed',
        ]);

        $user = User::find($id);

        $user->username = $request->input('username');
        $user->name = $request->input('name');
        $user->role = $request->input('role');
        if (!empty($request->input('password'))){
            $user->password = bcrypt($request->input('password'));
        }

        $user->save();

        return redirect('/vartotojai')->with('success', 'Vartotojas sėkmingai atnaujintas!');
    }
}
