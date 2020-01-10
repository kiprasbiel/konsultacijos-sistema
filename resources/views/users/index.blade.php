<?php
$county_list = ["akmenes-r" => "Akmenės r.", "alytaus-m" => "Alytaus m.", "alytaus-r" => "Alytaus r.", "anyksciu-r" => "Anykščių r.", "birstono" => "Birštono", "birzu-r" => "Biržų r.", "druskininku" => "Druskininkų", "elektrenu" => "Elektrėnų", "ignalinos-r" => "Ignalinos r.", "jonavos-r" => "Jonavos r.", "joniskio-r" => "Joniškio r.", "jurbarko-r" => "Jurbarko r.", "kaisiadoriu-r" => "Kaišiadorių r.", "kalvarijos" => "Kalvarijos", "kauno-m" => "Kauno m.", "kauno-r" => "Kauno r.", "kazlu-rudos" => "Kazlų Rūdos", "kelmes-r" => "Kelmės r.", "kedainiu-r" => "Kėdainių r.", "klaipedos-m" => "Klaipėdos m.", "klaipedos-r" => "Klaipėdos r.", "kretingos-r" => "Kretingos r.", "kupiskio-r" => "Kupiškio r.", "lazdiju-r" => "Lazdijų r.", "marijampoles" => "Marijampolės", "mazeikiu-r" => "Mažeikių r.", "moletu-r" => "Molėtų r.", "neringos" => "Neringos", "pagegiu" => "Pagėgių", "pakruojo-r" => "Pakruojo r.", "palangos-m" => "Palangos m.", "panevezio-m" => "Panevėžio m.", "panevezio-r" => "Panevėžio r.", "pasvalio-r" => "Pasvalio r.", "plunges-r" => "Plungės r.", "prienu-r" => "Prienų r.", "radviliskio-r" => "Radviliškio r.", "raseiniu-r" => "Raseinių r.", "rietavo" => "Rietavo", "rokiskio-r" => "Rokiškio r.", "skuodo-r" => "Skuodo r.", "sakiu-r" => "Šakių r.", "salcininku-r" => "Šalčininkų r.", "siauliu-m" => "Šiaulių m.", "siauliu-r" => "Šiaulių r.", "silales-r" => "Šilalės r.", "silutes-r" => "Šilutės r.", "sirvintu-r" => "Širvintų r.", "svencioniu-r" => "Švenčionių r.", "taurages-r" => "Tauragės r.", "telsiu-r" => "Telšių r.", "traku-r" => "Trakų r.", "ukmerges-r" => "Ukmergės r.", "utenos-r" => "Utenos r.", "varenos-r" => "Varėnos r.", "vilkaviskio-r" => "Vilkaviškio r.", "vilniaus-m" => "Vilniaus m.", "vilniaus-r" => "Vilniaus r.", "visagino-m" => "Visagino m.", "zarasu-r" => "Zarasų r."];
?>

@extends('layouts.app')

@section('content')

    <div class="row">
        <div class="col-md-6">
            <h1>Vartotojai</h1>
        </div>
        <div class="col-md-6">
            <a href="/create-user" class="btn btn-success float-right">Kurti naują vartoją</a>
        </div>
    </div>


    @if(count($users)>0)
        <table class="table">
            <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Vardas</th>
                <th scope="col">Prisijungimo vardas</th>
                <th scope="col">Reg. data</th>
                <th scope="col">Rolė</th>
                <th scope="col"></th>
            </tr>
            </thead>
            <tbody>
            @foreach($users as $user)
                <tr>
                    <th scope="row">{{$user->id}}</th>
                    <td>{{$user->name}}</td>
                    <td>{{$user->username}}</td>
                    <td>{{$user->created_at}}</td>
                    <td>
                        @if ($user->role == 1)
                            Administratorius
                        @elseif ($user->role == 2)
                            Konsultantas
                        @endif
                    </td>
                    <td>
                        <div class="d-inline-flex">
                            <a href="/vartotojai/{{$user->id}}/edit" data-toggle="tooltip"
                               data-placement="top" title="Redaguoti vartotoją">
                                <span class="icons">
                                    <i class="far fa-edit"></i>
                                </span>
                            </a>
{{--                            {{Form::open(['action' => ['ConsultationController@destroy', $consultation->id], 'method' => 'POST'])}}--}}
{{--                            {{Form::hidden('_method', 'DELETE')}}--}}
{{--                            {{Form::button('<i class="fa fa-trash"></i>', ['type' => 'submit', 'class' => 'btn aw-trash-button', 'data-toggle' => 'tooltip', 'data-placement' => 'top', 'title' => 'Ištrinti konsultaciją', 'onclick' => "return confirm('Ar tikrai norite ištrinti konsultaciją?')"])}}--}}
{{--                            {{Form::close()}}--}}
                        </div>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        {{$users->links()}}
    @else
        <p>Vartotojų nerasta</p>
    @endif

@endsection
