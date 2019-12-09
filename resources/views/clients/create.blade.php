<?php
$county_list = ["akmenes-r" => "Akmenės r.", "alytaus-m" => "Alytaus m.", "alytaus-r" => "Alytaus r.", "anyksciu-r" => "Anykščių r.", "birstono" => "Birštono", "birzu-r" => "Biržų r.", "druskininku" => "Druskininkų", "elektrenu" => "Elektrėnų", "ignalinos-r" => "Ignalinos r.", "jonavos-r" => "Jonavos r.", "joniskio-r" => "Joniškio r.", "jurbarko-r" => "Jurbarko r.", "kaisiadoriu-r" => "Kaišiadorių r.", "kalvarijos" => "Kalvarijos", "kauno-m" => "Kauno m.", "kauno-r" => "Kauno r.", "kazlu-rudos" => "Kazlų Rūdos", "kelmes-r" => "Kelmės r.", "kedainiu-r" => "Kėdainių r.", "klaipedos-m" => "Klaipėdos m.", "klaipedos-r" => "Klaipėdos r.", "kretingos-r" => "Kretingos r.", "kupiskio-r" => "Kupiškio r.", "lazdiju-r" => "Lazdijų r.", "marijampoles" => "Marijampolės", "mazeikiu-r" => "Mažeikių r.", "moletu-r" => "Molėtų r.", "neringos" => "Neringos", "pagegiu" => "Pagėgių", "pakruojo-r" => "Pakruojo r.", "palangos-m" => "Palangos m.", "panevezio-m" => "Panevėžio m.", "panevezio-r" => "Panevėžio r.", "pasvalio-r" => "Pasvalio r.", "plunges-r" => "Plungės r.", "prienu-r" => "Prienų r.", "radviliskio-r" => "Radviliškio r.", "raseiniu-r" => "Raseinių r.", "rietavo" => "Rietavo", "rokiskio-r" => "Rokiškio r.", "skuodo-r" => "Skuodo r.", "sakiu-r" => "Šakių r.", "salcininku-r" => "Šalčininkų r.", "siauliu-m" => "Šiaulių m.", "siauliu-r" => "Šiaulių r.", "silales-r" => "Šilalės r.", "silutes-r" => "Šilutės r.", "sirvintu-r" => "Širvintų r.", "svencioniu-r" => "Švenčionių r.", "taurages-r" => "Tauragės r.", "telsiu-r" => "Telšių r.", "traku-r" => "Trakų r.", "ukmerges-r" => "Ukmergės r.", "utenos-r" => "Utenos r.", "varenos-r" => "Varėnos r.", "vilkaviskio-r" => "Vilkaviškio r.", "vilniaus-m" => "Vilniaus m.", "vilniaus-r" => "Vilniaus r.", "visagino-m" => "Visagino m.", "zarasu-r" => "Zarasų r."];
?>

@extends('layouts.app')

@section('head-content')
    <link href="{{ asset('css/select2.css') }}" rel="stylesheet">
@endsection

@section('content')

    <div class="row">
        <div class="col">
            <h1>Pridėti naują klientą</h1>
        </div>
    </div>
    {!! Form::open(['action' => 'ClientController@store', 'method' => 'POST']) !!}
    <div class="row">
        <div class="col-md-4">
            <div class="form-group">
                {{Form::label('name', 'Įmonės pavadinimas')}}
                {{Form::text('name', '', ['class' => 'form-control'])}}
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                {{Form::label('code', 'Įmonės kodas')}}
                {{Form::text('code', '', ['class' => 'form-control'])}}
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                {{Form::label('company_reg_date', 'Įmonės registracijos data')}}
                {{Form::date('company_reg_date', \Carbon\Carbon::now(), ['class' => 'form-control'])}}
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4">
            <div class="form-group">
                {{Form::label('reg_county', 'Registracijos sąvivaldybė')}}
                {{Form::select('reg_county', $county_list, null, ['class' => 'select2 form-control reg_county', 'placeholder' => "Pasirinkite savivaldybę"])}}
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                {{Form::label('con_type', 'Konsultacijos tipas')}}
                <select multiple class="form-control" id="con_type" name="con_type[]">
                    <option>VKT</option>
                    <option>EXPO</option>
                    <option>ECO</option>
                </select>
            </div>
        </div>
    </div>
    <div class="row aw-text-area-180">
        <div class="col-md-6">
            {{Form::label('contacts', 'Kontaktai')}}
            {{Form::textarea('contacts', '', ['class' => 'form-control', 'style' => 'height: 30%'])}}
        </div>
    </div>
    <div class="row">
        <div class="col-md">
            {{Form::submit('Sukurti', ['class'=> 'btn btn-primary float-right'])}}
        </div>
    </div>

    {!! Form::close() !!}
@endsection

@section('foot-content')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/js/select2.min.js" defer></script>
    <script src="{{ asset('js/consultation-frontend-logic.js') }}" defer></script>

@endsection