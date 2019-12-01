@extends('layouts.app')

@section('content')

    <div class="row">
        <div class="col-md-6">
            <h1>Būsimos konsultacijos</h1>
        </div>
        <div class="col-md-6 text-right">
            <a href="/conf-month-gen" class="btn btn-primary">Konfigūruoti mėnesio ataskaitą</a>
        </div>
    </div>
        @if(count($consultations)>0)
            <table class="table">
                <thead>
                <tr>
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
                                <div class="d-inline-flex">
                                    <a href="/konsultacijos/{{$consultation->id}}/edit" data-toggle="tooltip"
                                       data-placement="top" title="Redaguoti konsultaciją">
                                <span class="icons">
                                    <i class="far fa-edit"></i>
                                </span>
                                    </a>
                                    {{Form::open(['action' => ['ConsultationController@destroy', $consultation->id], 'method' => 'POST'])}}
                                    {{Form::hidden('_method', 'DELETE')}}
                                    {{Form::button('<i class="fa fa-trash"></i>', ['type' => 'submit', 'class' => 'btn aw-trash-button', 'data-toggle' => 'tooltip', 'data-placement' => 'top', 'title' => 'Ištrinti konsultaciją'])}}
                                    {{Form::close()}}
                                </div>
                            </div>

                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        @else
            <p>Konsultacijų nerasta</p>
        @endif

    <div class="container pt-5">
        <div class="row">
            <div class="col-md-4 text-center">
            </div>
        </div>
    </div>
@endsection
