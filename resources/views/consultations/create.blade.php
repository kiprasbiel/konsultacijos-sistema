<?php
$county_list = ["akmenes-r" => "Akmenės r.", "alytaus-m" => "Alytaus m.", "alytaus-r" => "Alytaus r.", "anyksciu-r" => "Anykščių r.", "birstono" => "Birštono", "birzu-r" => "Biržų r.", "druskininku" => "Druskininkų", "elektrenu" => "Elektrėnų", "ignalinos-r" => "Ignalinos r.", "jonavos-r" => "Jonavos r.", "joniskio-r" => "Joniškio r.", "jurbarko-r" => "Jurbarko r.", "kaisiadoriu-r" => "Kaišiadorių r.", "kalvarijos" => "Kalvarijos", "kauno-m" => "Kauno m.", "kauno-r" => "Kauno r.", "kazlu-rudos" => "Kazlų Rūdos", "kelmes-r" => "Kelmės r.", "kedainiu-r" => "Kėdainių r.", "klaipedos-m" => "Klaipėdos m.", "klaipedos-r" => "Klaipėdos r.", "kretingos-r" => "Kretingos r.", "kupiskio-r" => "Kupiškio r.", "lazdiju-r" => "Lazdijų r.", "marijampoles" => "Marijampolės", "mazeikiu-r" => "Mažeikių r.", "moletu-r" => "Molėtų r.", "neringos" => "Neringos", "pagegiu" => "Pagėgių", "pakruojo-r" => "Pakruojo r.", "palangos-m" => "Palangos m.", "panevezio-m" => "Panevėžio m.", "panevezio-r" => "Panevėžio r.", "pasvalio-r" => "Pasvalio r.", "plunges-r" => "Plungės r.", "prienu-r" => "Prienų r.", "radviliskio-r" => "Radviliškio r.", "raseiniu-r" => "Raseinių r.", "rietavo" => "Rietavo", "rokiskio-r" => "Rokiškio r.", "skuodo-r" => "Skuodo r.", "sakiu-r" => "Šakių r.", "salcininku-r" => "Šalčininkų r.", "siauliu-m" => "Šiaulių m.", "siauliu-r" => "Šiaulių r.", "silales-r" => "Šilalės r.", "silutes-r" => "Šilutės r.", "sirvintu-r" => "Širvintų r.", "svencioniu-r" => "Švenčionių r.", "taurages-r" => "Tauragės r.", "telsiu-r" => "Telšių r.", "traku-r" => "Trakų r.", "ukmerges-r" => "Ukmergės r.", "utenos-r" => "Utenos r.", "varenos-r" => "Varėnos r.", "vilkaviskio-r" => "Vilkaviškio r.", "vilniaus-m" => "Vilniaus m.", "vilniaus-r" => "Vilniaus r.", "visagino-m" => "Visagino m.", "zarasu-r" => "Zarasų r."];
?>
@extends('layouts.app')

@section('head-content')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/css/select2.min.css" rel="stylesheet"/>
@endsection

@section('content')
    <div class="row align-items-center">
        <div class="col-md-auto">
            <h1>Nauja konsultacija</h1>
        </div>
        <div class="col-md-auto">
            <div class="custom-control custom-checkbox">
                <input form="consultation-create" type="checkbox" class="custom-control-input" id="old-con" name="old">
                <label class="custom-control-label" for="old-con">Praėjusi konsultacija</label>
            </div>
        </div>
    </div>
    {!! Form::open(['action' => 'ConsultationController@store', 'method' => 'POST', 'id' => 'consultation-create']) !!}
    <div class="aw-group-nest" id="aw-group-nest">
        <div class="aw-form-group" id="aw-form-group-0">
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        {{Form::label('company_id', 'Įmonės pavadinimas')}}
                        {{Form::select('company_id', [], null, ['class' => 'form-control select2 company_id', 'id' => 'company_id'])}}
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        {{Form::label('contacts', 'Kontaktai')}}
                        {{Form::text('contacts', '', ['class' => 'form-control'])}}
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        {{Form::label('theme', 'Tema')}}
                        {{Form::select('theme', [], null, ['class' => 'form-control select2 theme', 'id' => 'theme'])}}
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        {{Form::label('reg_county', 'Paslaugų teikimo savivaldybė')}}
                        {{Form::select('reg_county', $county_list, null, ['class' => 'select2 form-control reg_county', 'placeholder' => "Pasirinkite savivaldybę"])}}
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        {{Form::label('address', 'Paslaugų teikimo adresas')}}
                        {{Form::text('address', '',   ['class' => 'form-control'])}}
                    </div>
                </div>
                <div class="col-md-4">
                    {{Form::label('user_id', 'Konsultantas')}}
                    {{Form::select('user_id', $users, null, ['class' => 'form-control user_id', 'id' => 'user_id', 'placeholder' => "Pasirinkite konsultantą"])}}
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        {{Form::label('consultation_date', 'Konsultacijos data')}}
                        {{Form::date('consultation_date', \Carbon\Carbon::now(), ['class' => 'form-control'])}}
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        {{Form::label('consultation_start', 'Konsultacijos pradžia')}}
                        {{Form::text('consultation_start', '',   ['class' => 'form-control', 'placeholder' => '00:00'])}}
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        {{Form::label('consultation_length', 'Konsultacijos trukmė')}}
                        {{Form::text('consultation_length', '',   ['class' => 'form-control', 'placeholder' => '00:00'])}}
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        {{Form::label('method', 'Metodas')}}
                        {{Form::select('method', ['Telefonu' => 'Telefonu', 'Skype' => 'Skype', 'Susitikimas' => 'Susitikimas'], null, ['class' => 'form-control method'])}}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="break_container"></div>
    <button id="aw_add_additional_break" type="button" class="btn btn-primary">Pridėti pertrauką</button>

    <div class="row">
        <div class="col-md">
            <button class="btn btn-secondary float-right mx-1 aw-a-button" id="duplicate" type="submit" name="action" value="duplicate">Išsaugoti ir duplikuoti</button>
            <button class="btn btn-primary float-right mx-1" type="submit" name="action" value="save">Išsaugoti</button>
        </div>
    </div>

    {!! Form::close() !!}
@endsection

@section('foot-content')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/js/select2.min.js" defer></script>
    <script src="{{ asset('js/consultation-frontend-logic.js') }}" defer></script>

    <script type="text/javascript">
        jQuery(document).ready(function ($) {
            // Removing rows
            $("#break_container").on('click', '.aw_remove_break', function () {
                const value = $(this).val();
                $("#break-" + value).remove();
            });

            let template_row =  `
                    <div class="row aw_break_row" id="break-0">
                    <div class="col-sm-4">
                        <div class="row">
                            <div class="col-8 col-sm-5 form-group">
                                <label>
                                    Pertraukos pradžia
                                    <input class="form-control break-start-field" name="break[0][break_start]" type="text"
                                           value="" placeholder="00:00">
                                </label>
                            </div>
                            <div class="col-4 col-sm-5 form-group">
                                <label>
                                    Pertraukos pabaiga
                                    <input class="form-control break-end-field" name="break[0][break_end]" type="text"
                                           value="" placeholder="00:00">
                                </label>
                            </div>
                            <div class="col-2 col-sm-2 form-group pt-4 pl-0">
                                <button type="button" value="0" id="remove-break-0"
                                        class="btn aw-trash-button aw_remove_break"><i
                                        class="fas fa-minus-circle aw-minus-circle-red"></i></button>
                            </div>
                        </div>
                    </div>
                </div>
                `;
            let currant_index = 0;

            // Adding rows
            $('#aw_add_additional_break').click(function () {

                if (currant_index === 0) {
                    $('#break_container').html(template_row);
                }
                else {
                    // let new_row = template_row.last().clone();
                    let new_row = $('.aw_break_row').last().clone();
                    new_row.attr('id', 'break-' + currant_index);
                    new_row.find('.aw_remove_break').attr('id', 'remove-break-' + currant_index).val(currant_index);
                    new_row.find('.break-start-field').val('').attr('name', 'break[' + currant_index + '][break_start]');
                    new_row.find('.break-end-field').val('').attr('name', 'break[' + currant_index + '][break_end]');
                    new_row.appendTo('#break_container');
                }
                currant_index++;
            });
        });
    </script>
@endsection
