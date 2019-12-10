@extends('layouts.app')

@section('head-content')

@endsection


@section('content')
    {!! Form::open(['action' => 'ExcelExportController@store', 'method' => 'POST']) !!}
    <div class="row">
        <div class="col-md-6">
            <h1>Neišsiųstos konsultacijos</h1>
        </div>
        <div class="col-md-6">
            <button class="btn btn-primary float-right mx-1" type="submit" name="action" value="send" onclick="return confirm('Ar tikrai norite išsiųsti konsultacijas?')">Siųsti</button>
            <button class="btn btn-secondary float-right mx-1" type="submit" name="action" value="export">Peržiūrėti XLSX</button>
        </div>
    </div>

    @if(count($consultations)>0)
        <table class="table">
            <thead>
            <tr>
                <th scope="col">Siųsti?</th>
                <th scope="col">#</th>
                <th scope="col">Įmonės pavadinimas</th>
                <th scope="col">Kontaktai</th>
                <th scope="col">Tema</th>
                <th scope="col">Adresas</th>
                <th scope="col">Konsultacijos data</th>
                <th scope="col">Konsultacijos trukmė</th>
                <th scope="col">Metodas</th>
                <th scope="col">Apmokėta?</th>
                <th scope="col">Išsiųsta?</th>
                <th scope="col"></th>
            </tr>
            </thead>
            <tbody>
            @foreach($consultations as $consultation)
                <tr>
                    <td>
                        <input name="send[]" type="checkbox" class="form-control aw-checkbox" id="send-checkbox" value="{{$consultation->id}}">
                    </td>
                    <th scope="row">{{$consultation->id}}</th>
                    <td>{{$consultation->client->name}}</td>
                    <td>{{$consultation->contacts}}</td>
                    <td>{{$consultation->theme->name}}</td>
                    <td>{{$consultation->address}}</td>
                    <td>{{$consultation->consultation_date}}</td>
                    <td>{{$consultation->consultation_length}}</td>
                    <td>{{$consultation->method}}</td>
                    <td>
                        @if ($consultation->is_paid==1)
                            <span class="icons"><i class="far fa-money-bill-alt paid"></i></span>
                        @else
                            <span class="icons"><i class="far fa-money-bill-alt not-paid"></i></span>
                        @endif
                    </td>
                    <td>
                        @if ($consultation->is_sent==1)
                            Taip
                        @else
                            Ne
                        @endif
                    </td>
                    <td>
                        <div class="d-inline-flex">
                            <a href="/konsultacijos/{{$consultation->id}}/edit" data-toggle="tooltip"
                               data-placement="top" title="Redaguoti konsultaciją">
                                <span class="icons">
                                    <i class="far fa-edit"></i>
                                </span>
                            </a>
                        </div>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        {{$consultations->links()}}
    @else
        <p>Konsultacijų nerasta</p>
    @endif

    <div class="row">
        <div class="col-md-4">

        </div>
    </div>

    {!! Form::close() !!}
@endsection


@section('foot-content')
@endsection