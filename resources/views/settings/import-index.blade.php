@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-6">
            <h1>Importas</h1>
        </div>
    </div>

    <div class="row justify-content-md-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    Konsultacijų importavimas per CSV
                </div>
                <div class="card-body">
                    {!! Form::open(['action' => 'ImportController@import', 'method' => 'POST', 'files' => true]) !!}

                    {{Form::file('csv')}}

                    {{Form::submit('Importuoti', ['class'=> 'btn btn-success float-right mx-2', 'name' => 'action'])}}
                    {{Form::submit('Tikrinti', ['class'=> 'btn btn-primary float-right mx-2', 'name' => 'action'])}}
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>


    @if(!empty($con_arr))
        @dump($con_arr)
        <div class="row pt-4">
            <table class="table">
                <thead>
                <tr>
                    <th>Nr.</th>
                    <th>Klientas</th>
                    <th>Sukūrė</th>
                    <th>Kontaktai</th>
                    <th>Tema</th>
                    <th>Konsultantas</th>
                    <th>Adresas</th>
                    <th>Konsultacijos data</th>
                    <th>Konsultacijos laikas</th>
                    <th>Konsultacijos trukmė</th>
                    <th>Pertraukos pradžia</th>
                    <th>Pertraukos pabaiga</th>
                    <th>Metodas</th>
                    <th>Apskrytis</th>
                </tr>
                </thead>
                @foreach($con_arr as $key=>$con)
                    <tr>
                        <td>{{$key+1}}</td>
                        <td>
                            @if($con['client_id'] != null)
                                {{\App\Client::find($con['client_id'])->name ?? 'ERROR'}}
                            @else
                                <div class="aw-error">ERROR</div>
                            @endif
                        </td>
                        <td>
                            @if($con['created_by'] != null)
                                {{\App\User::find($con['created_by'])->name}}
                            @else
                                <div class="aw-error">ERROR</div>
                            @endif
                        </td>
                        <td>{{$con['contacts']}}</td>
                        <td>
                            @if($con['theme_id'] != null)
                                {{\App\Theme::find($con['theme_id'])->name}}
                            @else
                                <div class="aw-error">ERROR</div>
                            @endif
                        </td>
                        <td>
                            @if($con['user_id'] != null)
                                {{\App\User::find($con['user_id'])->name}}
                            @else
                                <div class="aw-error">ERROR</div>
                            @endif
                        </td>
                        <td>{{$con['address']}}</td>
                        <td>{{$con['consultation_date']}}</td>
                        <td>{{$con['consultation_time']}}</td>
                        <td>{{$con['consultation_length']}}</td>
                        <td>{{$con['break_start']}}</td>
                        <td>{{$con['break_end']}}</td>
                        <td>{{$con['method']}}</td>
                        <td>{{$con['county']}}</td>
                    </tr>
                @endforeach
            </table>
        </div>
        <div class="row">
            <div class="col-md">
                {!! Form::open(['action' => ['ImportController@save'], 'method' => 'POST']) !!}
                <input type="hidden" name="file_path" value="{{$file_path}}">
                <button id="import-submit" class="btn btn-primary float-right" type="submit">Importuoti</button>
                {!! Form::close() !!}

            </div>
        </div>


    @endif


@endsection

