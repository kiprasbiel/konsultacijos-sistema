<?php

namespace App\Http\Controllers;

use App\Option;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');

    }

    public function index(){
        return view('settings.index');
    }

    public function set_options(Request $request){
        foreach ($request->input() as $key=>$value) {
            if ($key == '_token'){
                continue;
            }
            elseif (Option::where('name', $key)->count() == 0) {
                $option = new Option;
                $option->name = $key;
                $option->value = $value;
                $option->save();
            }
            else{
                $option = Option::where('name', $key);
                $option->update(['value' => $value]);
            }
        }

        return redirect('/settings')->with('success', 'Nustatymai sėkmingai atnaujinti!');
    }
}
