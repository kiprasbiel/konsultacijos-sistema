@extends('layouts.app')

@section('head-content')

@endsection


@section('content')
    <div class="row">
        <div class="col-md-6">
            <h1>Mėnesio ataskaitos konfigūravimas</h1>
        </div>
    </div>

    {!! Form::open(['action' => 'ExcelExportController@configure', 'method' => 'POST']) !!}
    <div class="row">
        <div class="col-md-4">
            <div class="form-group">
                {{Form::label('ex-date', 'Pasirinkite apmokėjim metus ir mėnesį')}}
                <input type="month" id="ex-date" name="ex-date" class="form-control">
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                {{Form::label('con_type', 'Pasirinkite ataskaitos tipą')}}
                {{Form::select('con_type', ['VKT' => 'VKT', 'EXPO' => 'EXPO', 'ECO' => 'ECO'], null,   ['class' => 'form-control', 'placeholder' => "Pasirinkite tipą"])}}
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md">
            <button class="btn btn-primary float-right mx-1 aw-a-button" id="duplicate" type="submit" name="action" value="send" onclick="return confirm('Ar tikrai norite išsiųsti mėnesio atsakaitą?')">Generuoti ir išsiųsti</button>
            <button class="btn btn-secondary float-right mx-1 aw-a-button" id="duplicate" type="submit" name="action" value="download">Atsisiųsti XLSX</button>
        </div>
    </div>

    {!! Form::close() !!}
@endsection


@section('foot-content')
    <script src="{{ asset('js/consultation-frontend-logic.js') }}" defer></script>
@endsection