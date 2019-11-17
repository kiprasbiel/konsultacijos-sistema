<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class TestAjaxController extends Controller {
    public function index(Request $request) {
        $msg = "This is a simple message.";
        return response()->json(array('msg'=> $request->pasisveikinimas), 200);
    }
}