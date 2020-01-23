<?php
$county_list = ["akmenes-r" => "Akmenės r.", "alytaus-m" => "Alytaus m.", "alytaus-r" => "Alytaus r.", "anyksciu-r" => "Anykščių r.", "birstono" => "Birštono", "birzu-r" => "Biržų r.", "druskininku" => "Druskininkų", "elektrenu" => "Elektrėnų", "ignalinos-r" => "Ignalinos r.", "jonavos-r" => "Jonavos r.", "joniskio-r" => "Joniškio r.", "jurbarko-r" => "Jurbarko r.", "kaisiadoriu-r" => "Kaišiadorių r.", "kalvarijos" => "Kalvarijos", "kauno-m" => "Kauno m.", "kauno-r" => "Kauno r.", "kazlu-rudos" => "Kazlų Rūdos", "kelmes-r" => "Kelmės r.", "kedainiu-r" => "Kėdainių r.", "klaipedos-m" => "Klaipėdos m.", "klaipedos-r" => "Klaipėdos r.", "kretingos-r" => "Kretingos r.", "kupiskio-r" => "Kupiškio r.", "lazdiju-r" => "Lazdijų r.", "marijampoles" => "Marijampolės", "mazeikiu-r" => "Mažeikių r.", "moletu-r" => "Molėtų r.", "neringos" => "Neringos", "pagegiu" => "Pagėgių", "pakruojo-r" => "Pakruojo r.", "palangos-m" => "Palangos m.", "panevezio-m" => "Panevėžio m.", "panevezio-r" => "Panevėžio r.", "pasvalio-r" => "Pasvalio r.", "plunges-r" => "Plungės r.", "prienu-r" => "Prienų r.", "radviliskio-r" => "Radviliškio r.", "raseiniu-r" => "Raseinių r.", "rietavo" => "Rietavo", "rokiskio-r" => "Rokiškio r.", "skuodo-r" => "Skuodo r.", "sakiu-r" => "Šakių r.", "salcininku-r" => "Šalčininkų r.", "siauliu-m" => "Šiaulių m.", "siauliu-r" => "Šiaulių r.", "silales-r" => "Šilalės r.", "silutes-r" => "Šilutės r.", "sirvintu-r" => "Širvintų r.", "svencioniu-r" => "Švenčionių r.", "taurages-r" => "Tauragės r.", "telsiu-r" => "Telšių r.", "traku-r" => "Trakų r.", "ukmerges-r" => "Ukmergės r.", "utenos-r" => "Utenos r.", "varenos-r" => "Varėnos r.", "vilkaviskio-r" => "Vilkaviškio r.", "vilniaus-m" => "Vilniaus m.", "vilniaus-r" => "Vilniaus r.", "visagino-m" => "Visagino m.", "zarasu-r" => "Zarasų r."];
?>

@extends('layouts.app')

@section('head-content')
@endsection

@section('content')
    <div class="row align-items-center">
        <div class="col-md-6">
            <h1>Konsultacija <strong>#{{$consultation->id}}</strong></h1>
        </div>
        <div class="col-md-6">
            <a class="float-right" href="/konsultacijos/{{$consultation->id}}/edit" data-toggle="tooltip"
               data-placement="top" title="Redaguoti konsultaciją"><span class="icons"><i class="far fa-edit"></i></span>
            </a>
            {{Form::open(['action' => ['ConsultationController@destroy', $consultation->id], 'method' => 'POST'])}}
            {{Form::hidden('_method', 'DELETE')}}
            {{Form::button('<i class="fa fa-trash"></i>', ['type' => 'submit', 'class' => 'btn aw-trash-button float-right', 'data-toggle' => 'tooltip', 'data-placement' => 'top', 'title' => 'Ištrinti konsultaciją', 'onclick' => "return confirm('Ar tikrai norite ištrinti konsultaciją? Jei konsultacija dar nepraėjusi ir išsiųsta - bus išsiųsta atąskaita.')"])}}
            {{Form::close()}}
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
            <div class="form-group">
                {{Form::label('company_id', 'Įmonės pavadinimas')}}
                {{Form::select('company_id', [$consultation->client->id => $consultation->client->name], $consultation->client->name, ['class' => 'form-control', 'id' => 'company_id_not_editable', 'readonly'])}}
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                {{Form::label('contacts', 'Kontaktai')}}
                {{Form::text('contacts', $consultation->contacts, ['class' => 'form-control', 'readonly'])}}
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                {{Form::label('theme', 'Tema')}}
                {{Form::select('theme', [$consultation->theme->id => $consultation->theme->name], $consultation->theme->name, ['class' => 'form-control ', 'id' => 'theme_not_editable', 'readonly'])}}
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4">
            <div class="form-group">
                {{Form::label('reg_county', 'Registracijos sąvivaldybė')}}
                {{Form::select('reg_county', $county_list, $consultation->county, ['class' => 'select2 form-control', 'placeholder' => "Pasirinkite savivaldybę", 'readonly'])}}
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                {{Form::label('address', 'Adresas')}}
                {{Form::text('address', $consultation->address, ['class' => 'form-control', 'readonly'])}}
            </div>
        </div>
        <div class="col-md-4">
            {{Form::label('user_id', 'Konsultantas')}}
            {{Form::select('user_id', $users, $consultation->user_id, ['class' => 'form-control user_id', 'id' => 'user_id', 'placeholder' => "Pasirinkite konsultantą", 'readonly'])}}
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
            <div class="form-group">
                {{Form::label('consultation_date', 'Konsultacijos data')}}
                {{Form::date('consultation_date', $consultation->consultation_date, ['class' => 'form-control', 'readonly'])}}
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                {{Form::label('consultation_start', 'Konsultacijos pradžia')}}
                {{Form::text('consultation_start', $consultation->consultation_time,   ['class' => 'form-control', 'placeholder' => '00:00', 'readonly'])}}
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                {{Form::label('consultation_length', 'Konsultacijos trukmė')}}
                {{Form::text('consultation_length', $consultation->consultation_length,   ['class' => 'form-control', 'placeholder' => '00:00','readonly'])}}
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-4">
            <div class="row">
                <div class="col-8 col-sm-5 form-group">
                    {{Form::label('break_start', 'Pertraukos pradžia')}}
                    {{Form::text('break_start', $consultation->break_start,   ['class' => 'form-control', 'placeholder' => '00:00', 'readonly'])}}
                </div>
                <div class="col-4 col-sm-5 form-group">
                    {{Form::label('break_end', 'Pertraukos pabaiga')}}
                    {{Form::text('break_end', $consultation->break_end,   ['class' => 'form-control', 'placeholder' => '00:00', 'readonly'])}}
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                {{Form::label('method', 'Metodas')}}
                {{Form::select('method', ['Skype' => 'Skype', 'Telefonu' => 'Telefonu', 'Susitikimas' => 'Susitikimas'], $consultation->method, ['class' => 'form-control', 'readonly'])}}
            </div>
        </div>
    </div>

@endsection

@section('foot-content')
@endsection
