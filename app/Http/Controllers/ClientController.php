<?php

namespace App\Http\Controllers;

use App\CustomClasses\SearchTableColumns;
use App\CustomClasses\TableSort;
use App\Option;
use App\Rules\ValidateCompanyCode;
use Illuminate\Http\Request;
use App\Client;

class ClientController extends Controller
{

    private $pagination_int;

    public function __construct()
    {
        $this->middleware('auth');
        $this->pagination_int = Option::where('name', 'pagination_per_page')->value('value');

    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        //Default sorting
        $column = 'id';
        $column_sort = 'desc';

        //Checking if there is additional sorting passed
        if ($request->column !== null && $request->sort !== null) {
            $sorting = new TableSort;
            $clients = $sorting->sort_model('Client', $request->input('column'), $request->input('sort'), []);
            $pagination_sort = $request->input('sort');
            $column =  $request->input('column');
            $column_sort = $sorting->sort_toggle($request->input('sort'));
        }
        else{
            $clients =  Client::orderBy($column, $column_sort)->paginate($this->pagination_int);
            return view('clients.index')
                ->with('clients', $clients)
                ->with('column_sort', $column_sort);
        }

        return view('clients.index')
            ->with('clients', $clients)
            ->with('column_sort', $column_sort)
            ->with('pagination_sort', $pagination_sort)
            ->with('pagination_column', $column);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        return view('clients.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     *
     * Tikrinama, ar gerai ir ar visi laukeliai
     * uzpildyti kliento registracijos formoj
     *
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|unique:clients',
            'code' => ['required', 'unique:clients', new ValidateCompanyCode],
            'company_reg_date' => 'required',
            'con_type' => 'required',
            'contacts' => 'required'
        ]);
        $now = date_create(date("Y-m-d"));
        $registered_at = date_create($request->input('company_reg_date'));
        $how_old = date_diff($now,$registered_at)->y;


        $client = new Client;


        if (in_array('VKT', $request->input('con_type'))) {
            if ($how_old < 1) {
                $client->vkt = 'PR';
            } elseif ($how_old >= 1 && $how_old < 5) {
                $client->vkt = 'PL';
            }
        }

        if (in_array('EXPO', $request->input('con_type'))) {
            if ($how_old < 3) {
                $client->expo = 'IKI3';
            } elseif ($how_old >= 3) {
                $client->expo = 'PO3';
            }
        }

        if (in_array('ECO', $request->input('con_type'))) {
            $client->eco = 1;
        }



        $client->name = $request->input('name');
        $client->code = $request->input('code');
        $client->company_reg_date = $request->input('company_reg_date');
        $client->reg_county = $request->input('reg_county');
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
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
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
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required',
            'code' => 'required',
            'company_reg_date' => 'required',
            'con_type' => 'required',
            'contacts' => 'required'
        ]);

        $now = date_create(date("Y-m-d"));
        $registered_at = date_create($request->input('company_reg_date'));
        $how_old = date_diff($now,$registered_at)->y;

        $client = Client::find($id);

        if (in_array('VKT', $request->input('con_type'))) {
            if ($how_old < 1) {
                $client->vkt = 'PR';
            } elseif ($how_old >= 1 && $how_old < 5) {
                $client->vkt = 'PL';
            }
        }
        else{
            $client->vkt = null;
        }

        if (in_array('EXPO', $request->input('con_type'))) {
            if ($how_old < 3) {
                $client->expo = 'IKI3';
            } elseif ($how_old >= 3) {
                $client->expo = 'PO3';
            }
        }
        else{
            $client->expo = null;
        }

        if (in_array('ECO', $request->input('con_type'))) {
            $client->eco = 1;
        }
        else{
            $client->eco = null;
        }

        $client->name = $request->input('name');
        $client->code = $request->input('code');
        $client->company_reg_date = $request->input('company_reg_date');
        $client->reg_county = $request->input('reg_county');
        $client->contacts = $request->input('contacts');
        $client->user_id = auth()->user()->id;
        $client->save();

        return redirect('/klientai')->with('success', 'Klientas sėkmingai atnaujintas!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function destroy($id)
    {

        $client = Client::find($id);
        $client->consultations()->delete();
        $client->delete();

        return redirect('/klientai')->with('success', 'Klientas sėkmingai ištrintas!');
    }

    public function display_table_search_results(Request $request){
        $searchTableColumns = new SearchTableColumns();
        $clients = $searchTableColumns->tableSearchColumn($request->model, $request->column, $request->search);

        return view('clients.index')
            ->with('clients', $clients)
            ->with('column_sort', 'desc')
            ->with('table_search_model', $request->model)
            ->with('table_search_column', $request->column)
            ->with('table_search', $request->search);
    }

    public function list_sort(Request $request){
        dd($request->input());
    }
}
