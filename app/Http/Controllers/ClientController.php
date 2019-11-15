<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Client;

class ClientController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');

    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $clients =  Client::orderBy('created_at', 'desc')->paginate(50);
        return view('clients.index')->with('clients', $clients);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('clients.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     *
     * Tikrinama, ar gerai ir ar visi laukeliai
     * uzpildyti kliento registracijos formoj
     *
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'code' => 'required|unique:clients|digits_between:7,9',
            'company_reg_date' => 'required',
            'con_type' => 'required',
        ]);

        $client = new Client;
        $client->name = $request->input('name');
        $client->code = $request->input('code');
        $client->company_reg_date = $request->input('company_reg_date');
        $client->reg_county = $request->input('reg_county');
        $client->con_type = $request->input('con_type');
        $client->contacts = $request->input('contacts');
        $client->user_id = auth()->user()->id;
        $client->save();

        return redirect('/klientai')->with('success', 'Naujas klientas sėkmingai sukurtas!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $client = Client::find($id);
        return view('clients.edit')->with('client', $client);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required',
            'code' => 'required',
            'company_reg_date' => 'required',
            'con_type' => 'required',
        ]);

        $client = Client::find($id);
        $client->name = $request->input('name');
        $client->code = $request->input('code');
        $client->company_reg_date = $request->input('company_reg_date');
        $client->reg_county = $request->input('reg_county');
        $client->con_type = $request->input('con_type');
        $client->contacts = $request->input('contacts');
        $client->user_id = auth()->user()->id;
        $client->save();

        return redirect('/klientai')->with('success', 'Klientas sėkmingai atnaujintas!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $client = Client::find($id);
        $client->delete();

        return redirect('/klientai')->with('success', 'Klientas sėkmingai ištrintas!');
    }
}
