<?php
$county_list = ["akmenes-r" => "Akmenės r.", "alytaus-m" => "Alytaus m.", "alytaus-r" => "Alytaus r.", "anyksciu-r" => "Anykščių r.", "birstono" => "Birštono", "birzu-r" => "Biržų r.", "druskininku" => "Druskininkų", "elektrenu" => "Elektrėnų", "ignalinos-r" => "Ignalinos r.", "jonavos-r" => "Jonavos r.", "joniskio-r" => "Joniškio r.", "jurbarko-r" => "Jurbarko r.", "kaisiadoriu-r" => "Kaišiadorių r.", "kalvarijos" => "Kalvarijos", "kauno-m" => "Kauno m.", "kauno-r" => "Kauno r.", "kazlu-rudos" => "Kazlų Rūdos", "kelmes-r" => "Kelmės r.", "kedainiu-r" => "Kėdainių r.", "klaipedos-m" => "Klaipėdos m.", "klaipedos-r" => "Klaipėdos r.", "kretingos-r" => "Kretingos r.", "kupiskio-r" => "Kupiškio r.", "lazdiju-r" => "Lazdijų r.", "marijampoles" => "Marijampolės", "mazeikiu-r" => "Mažeikių r.", "moletu-r" => "Molėtų r.", "neringos" => "Neringos", "pagegiu" => "Pagėgių", "pakruojo-r" => "Pakruojo r.", "palangos-m" => "Palangos m.", "panevezio-m" => "Panevėžio m.", "panevezio-r" => "Panevėžio r.", "pasvalio-r" => "Pasvalio r.", "plunges-r" => "Plungės r.", "prienu-r" => "Prienų r.", "radviliskio-r" => "Radviliškio r.", "raseiniu-r" => "Raseinių r.", "rietavo" => "Rietavo", "rokiskio-r" => "Rokiškio r.", "skuodo-r" => "Skuodo r.", "sakiu-r" => "Šakių r.", "salcininku-r" => "Šalčininkų r.", "siauliu-m" => "Šiaulių m.", "siauliu-r" => "Šiaulių r.", "silales-r" => "Šilalės r.", "silutes-r" => "Šilutės r.", "sirvintu-r" => "Širvintų r.", "svencioniu-r" => "Švenčionių r.", "taurages-r" => "Tauragės r.", "telsiu-r" => "Telšių r.", "traku-r" => "Trakų r.", "ukmerges-r" => "Ukmergės r.", "utenos-r" => "Utenos r.", "varenos-r" => "Varėnos r.", "vilkaviskio-r" => "Vilkaviškio r.", "vilniaus-m" => "Vilniaus m.", "vilniaus-r" => "Vilniaus r.", "visagino-m" => "Visagino m.", "zarasu-r" => "Zarasų r."];
?>

@extends('layouts.app')

@section('head-content')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
    <link href="{{ asset('css/select2.css') }}" rel="stylesheet">
@endsection

@section('content')
    <div class="row align-items-center">
        <div class="col-md-auto">
            <h1>Redaguoti konsultaciją</h1>
        </div>
    </div>
    {!! Form::open(['action' => ['ConsultationController@update', $consultation->id], 'method' => 'POST']) !!}
    <div class="row">
        <div class="col-md-4">
            <div class="form-group">
                {{Form::label('company_id', 'Įmonės pavadinimas')}}
                {{Form::select('company_id', [$consultation->client->id => $consultation->client->name], $consultation->client->name, ['class' => 'form-control', 'id' => 'company_id_not_editable'])}}
{{--                {{Form::select('company_id', [$consultation->client->id => $consultation->client->name], $consultation->client->name, ['class' => 'form-control', 'id' => 'company_id_not_editable', 'readonly'])}}--}}
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                {{Form::label('contacts', 'Kontaktai')}}
                {{Form::text('contacts', $consultation->contacts, ['class' => 'form-control'])}}
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                {{Form::label('theme', 'Tema')}}
                {{Form::select('theme', [$consultation->theme->id => $consultation->theme->name], $consultation->theme->name, ['class' => 'form-control ', 'id' => 'theme_not_editable'])}}
{{--                {{Form::select('theme', [$consultation->theme->id => $consultation->theme->name], $consultation->theme->name, ['class' => 'form-control ', 'id' => 'theme_not_editable', 'readonly'])}}--}}
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4">
            <div class="form-group">
                {{Form::label('reg_county', 'Registracijos sąvivaldybė')}}
                {{Form::select('reg_county', $county_list, $consultation->county, ['class' => 'select2 form-control', 'placeholder' => "Pasirinkite savivaldybę"])}}
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                {{Form::label('address', 'Adresas')}}
                {{Form::text('address', $consultation->address, ['class' => 'form-control'])}}
            </div>
        </div>
        <div class="col-md-4">
            {{Form::label('user_id', 'Konsultantas')}}
            {{Form::select('user_id', $users, $consultation->user_id, ['class' => 'form-control user_id', 'id' => 'user_id', 'placeholder' => "Pasirinkite konsultantą"])}}
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
            <div class="form-group">
                {{Form::label('consultation_date', 'Konsultacijos data')}}
                {{Form::date('consultation_date', $consultation->consultation_date, ['class' => 'form-control'])}}
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                {{Form::label('consultation_start', 'Konsultacijos pradžia')}}
                {{Form::text('consultation_start', $consultation->consultation_time,   ['class' => 'form-control', 'placeholder' => '00:00'])}}
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                {{Form::label('consultation_length', 'Konsultacijos trukmė')}}
                {{Form::text('consultation_length', $consultation->consultation_length,   ['class' => 'form-control', 'placeholder' => '00:00'])}}
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-4">
            <div class="row">
                <div class="col-8 col-sm-5 form-group">
                    {{Form::label('break_start', 'Pertraukos pradžia')}}
                    {{Form::text('break_start', $consultation->break_start,   ['class' => 'form-control', 'placeholder' => '00:00'])}}
                </div>
                <div class="col-4 col-sm-5 form-group">
                    {{Form::label('break_end', 'Pertraukos pabaiga')}}
                    {{Form::text('break_end', $consultation->break_end,   ['class' => 'form-control', 'placeholder' => '00:00'])}}
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                {{Form::label('method', 'Metodas')}}
                {{Form::select('method', ['Telefonu' => 'Telefonu', 'Skype' => 'Skype', 'Susitikimas' => 'Susitikimas'], $consultation->method, ['class' => 'form-control'])}}
            </div>
        </div>
    </div>
    {{Form::hidden('_method', 'PUT')}}
    <div class="row">
        <div class="col-md">
            <button class="btn btn-primary float-right mx-1" type="submit" name="action" value="update" onclick="return confirm('Ar tikrai norite išsiųsti atnaujintą konsultaciją?')">Atnaujinti ir paskelbti</button>
            <button class="btn btn-secondary float-right mx-1 aw-a-button" type="submit" name="action" value="draft">Išsaugoti kaip juodraštį</button>
        </div>
    </div>

    {!! Form::close() !!}


@endsection

@section('foot-content')
    <script src="{{ asset('js/select2.js') }}" defer></script>
    <script src="{{ asset('js/formValidation.js') }}" defer></script>
@endsection
