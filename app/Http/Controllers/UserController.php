<?php

namespace App\Http\Controllers;

use App\Client;
use App\Consultation;
use App\Rules\ValidateUsername;
use App\User;
use Doctrine\DBAL\Schema\AbstractAsset;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function __construct() {
        $this->middleware('auth');

    }

    public function index(Request $request) {
        //Get array of consultants
        $users = User::where('role', 2)->get();
        $formatted_users = [];
        foreach ($users as $user) {
            $formatted_users[$user->id] = $user->name;
        }

        //Default sorting
        $column = 'id';
        $column_sort = 'desc';

        //Checking if there is additional sorting passed
        if (!empty($request->input())) {
            $column = $request->input('column');
            $column_sort = $request->input('sort');
        }
        $users = User::orderBy($column, $column_sort)->paginate(50);
        $pagination_sort = $column_sort;

        //Toggling sorting link
        if ($column_sort == 'desc') {
            $column_sort = 'asc';
        } else {
            $column_sort = 'desc';
        }

        return view('users.index')
            ->with('users', $users)
            ->with('column_sort', $column_sort)
            ->with('pagination_sort', $pagination_sort)
            ->with('pagination_column', $column)
            ->with('consultant_arr', $formatted_users);
    }

    public function create() {
        return view('auth.register');
    }

    public function edit($id) {
        $user = User::find($id);
        return view('users.edit')->with('user', $user);
    }

    public function update(Request $request, $id) {
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
        if (!empty($request->input('password'))) {
            $user->password = bcrypt($request->input('password'));
        }

        $user->save();

        return redirect('/vartotojai')->with('success', 'Vartotojas sėkmingai atnaujintas!');
    }

    public function destroy(Request $request,$id){
        if ($request->substitute_id == $id){
            return redirect('/vartotojai')->with('error', 'Negalima priskirti tam pačiam vartotojui. Pasirinkite kitą vartotoją.');
        }
        Client::where('user_id', $id)->update(['user_id'=>$request->substitute_id]);
        Consultation::where('user_id', $id)->update(['user_id'=>$request->substitute_id]);

        $user = User::find($id);
        $user->delete();

        return redirect('/vartotojai')->with('success', 'Vartotojas sėkmingai ištrintas ir susijusios konsultacijos ir klientas perregistruoti kitam vartotojui.');
    }
}
