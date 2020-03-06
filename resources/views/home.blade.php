@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-6">
            <h3>Šiuo metu vyksta <strong>{{$live_con_count}}</strong></h3>
        </div>
    </div>
    @if($live_con_count > 0)
        <table class="table">
            <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Įmonės pavadinimas</th>
                <th scope="col">Kontaktai</th>
                <th scope="col">Tema</th>
                <th scope="col">Adresas</th>
                <th scope="col">Konsultacijos pradžia</th>
                <th scope="col">Konsultacijos trukmė</th>
                <th scope="col">Konsultacijos pabaiga</th>
                <th scope="col">Metodas</th>
                <th scope="col">Apmokėta?</th>
                <th scope="col">Išsiųsta?</th>
                <th scope="col"></th>
            </tr>
            </thead>
            <tbody>
            @foreach($live_consultations as $live_con)
                <tr>
                    <th scope="row">{{$live_con->id}}</th>
                    <td>{{$live_con->client->name}}</td>
                    <td>{{$live_con->contacts}}</td>
                    <td>{{$live_con->theme->name}}</td>
                    <td>{{$live_con->address}}</td>
                    <td>{{$live_con->consultation_time}}</td>
                    <td>{{$live_con->consultation_length}}</td>
                    <td><strong>{{$live_con->con_end_datetime()->format('H:i:s')}}</strong></td>
                    <td>{{$live_con->method}}</td>
                    <td>
                        @if ($live_con->is_paid==1)
                            <span class="icons"><i class="far fa-money-bill-alt paid"></i></span>
                        @else
                            <span class="icons"><i class="far fa-money-bill-alt not-paid"></i></span>
                        @endif
                    </td>
                    <td>
                        @if ($live_con->is_sent==1)
                            Taip
                        @else
                            <strong style="color: red;">Ne</strong>
                        @endif
                    </td>
                    <td>
                        <div class="d-inline-flex">
                            <div class="d-inline-flex">
                                <a class="btn aw-bars-button" href="/konsultacijos/{{$live_con->id}}">
                                <span class="icons">
                                    <i class="fas fa-bars aw-bars"></i>
                                </span>
                                </a>
                                <a href="/konsultacijos/{{$live_con->id}}/edit" data-toggle="tooltip"
                                   data-placement="top" title="Redaguoti konsultaciją">
                                <span class="icons">
                                    <i class="far fa-edit"></i>
                                </span>
                                </a>
                            </div>
                        </div>

                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    @else
        <p>Nėra šiuo metu vykstančių konsultacijų</p>
    @endif

    <hr class="mt-4 mb-5">

    <div class="row">
        <div class="col-md-6">
            <h3>Šiandienos būsimos konsultacijos <strong>{{$con_count}}</strong></h3>
        </div>
    </div>
    @if($con_count > 0)
        <table class="table">
            <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Įmonės pavadinimas</th>
                <th scope="col">Kontaktai</th>
                <th scope="col">Tema</th>
                <th scope="col">Adresas</th>
                <th scope="col">Konsultacijos pradžia</th>
                <th scope="col">Konsultacijos trukmė</th>
                <th scope="col">Konsultacijos pabaiga</th>
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
                    <td>{{$consultation->consultation_time}}</td>
                    <td>{{$consultation->consultation_length}}</td>
                    <td><strong>{{$consultation->con_end_datetime()->format('H:i:s')}}</strong></td>
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
                            <strong style="color: red;">Ne</strong>
                        @endif
                    </td>
                    <td>
                        <div class="d-inline-flex">
                            <div class="d-inline-flex">
                                <a class="btn aw-bars-button" href="/konsultacijos/{{$consultation->id}}">
                                <span class="icons">
                                    <i class="fas fa-bars aw-bars"></i>
                                </span>
                                </a>
                                <a href="/konsultacijos/{{$consultation->id}}/edit" data-toggle="tooltip"
                                   data-placement="top" title="Redaguoti konsultaciją">
                                <span class="icons">
                                    <i class="far fa-edit"></i>
                                </span>
                                </a>
                            </div>
                        </div>

                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    @else
        <p>Šiandien nėra suplanuotų konsultacijų</p>
    @endif
@endsection
