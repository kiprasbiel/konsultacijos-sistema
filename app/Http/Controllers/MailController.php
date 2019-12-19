<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MailController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');

    }

//    public function store(Request $request){
//        Mail::to('test@test.com')->send(new ConsultationMail($data))->attach('storage/app/konsultacijos2019-10-31-04-10.xlsx');
//    }


}
