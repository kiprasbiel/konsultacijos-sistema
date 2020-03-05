@extends('layouts.app')

@section('head-content')

@endsection


@section('content')
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="card">
                <div class="card-header">
                    <h2 class="float-left">Mėnesio ataskaitos konfigūravimas</h2>
                    <button id="prefill-button" type="button" class="btn btn-success float-right" data-toggle="tooltip" data-placement="right" title="Užpildyti formą siuntimui"><i class="fas fa-check-square"></i></button>
                </div>
                <div class="card-body">
                    {!! Form::open(['action' => 'ExcelExportController@configure', 'method' => 'POST', 'id' => 'con-month-exp-form']) !!}

                    <div class="row mb-3">
                        <div class="col-md">
                            <label for="con-date-status">Pasirinkite, pagal ką eksportuoti</label>
                            <div id="con-date-status">
                                <div class="custom-control custom-radio">
                                    <input type="radio" id="con-date1" name="con-date" class="custom-control-input"
                                           value="paid_date">
                                    <label class="custom-control-label" for="con-date1">Apmokėjimo datą</label>
                                </div>
                                <div class="custom-control custom-radio">
                                    <input type="radio" id="con-date2" name="con-date" class="custom-control-input"
                                           value="consultation_date">
                                    <label class="custom-control-label" for="con-date2">Konsultacijos vykimo datą</label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md">
                            <div class="form-group">
                                {{Form::label('ex-date', 'Pasirinkite metus ir mėnesį')}}
                                <input type="month" id="ex-date" name="ex-date" class="form-control">
                            </div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md">
                            <label for="con-sent-status">Pasirinkite, kokias konsultaicjas eksportuoti</label>
                            <div id="con-sent-status">
                                <div class="custom-control custom-radio">
                                    <input type="radio" id="is-sent1" name="is-sent" class="custom-control-input"
                                           value="1">
                                    <label class="custom-control-label" for="is-sent1">Išsiųstas konsultacijas</label>
                                </div>
                                <div class="custom-control custom-radio">
                                    <input type="radio" id="is-sent2" name="is-sent" class="custom-control-input"
                                           value="0">
                                    <label class="custom-control-label" for="is-sent2">Neišsiųstas konsultacijas</label>
                                </div>
                                <div class="custom-control custom-radio">
                                    <input type="radio" id="is-sent3" name="is-sent" class="custom-control-input"
                                           value="all">
                                    <label class="custom-control-label" for="is-sent3">Visas</label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md">
                            <div class="form-group">
                                <label for="con_payment_status">Pasirinkite konsultaicjų apmokėjimo būseną</label>
                                <div id="con_payment_status">
                                    <div class="custom-control custom-radio">
                                        <input type="radio" id="con_payment1" name="con_payment"
                                               class="custom-control-input" value="1">
                                        <label class="custom-control-label" for="con_payment1">Apmokėtos
                                            konsultacijos</label>
                                    </div>
                                    <div class="custom-control custom-radio">
                                        <input type="radio" id="con_payment2" name="con_payment"
                                               class="custom-control-input" value="0">
                                        <label class="custom-control-label" for="con_payment2">Neapmokėtos
                                            konsultacijos</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md">
                            <div class="form-group">
                                <label for="con_type_status">Pasirinkite ataskaitos tipą</label>
                                <div id="con_type_status">
                                    <div class="custom-control custom-radio custom-control-inline">
                                        <input type="radio" id="con_type1" name="con_type" class="custom-control-input"
                                               value="VKT">
                                        <label class="custom-control-label" for="con_type1">VKT</label>
                                    </div>
                                    <div class="custom-control custom-radio custom-control-inline">
                                        <input type="radio" id="con_type2" name="con_type" class="custom-control-input"
                                               value="EXPO">
                                        <label class="custom-control-label" for="con_type2">EXPO</label>
                                    </div>
                                    <div class="custom-control custom-radio custom-control-inline">
                                        <input type="radio" id="con_type3" name="con_type" class="custom-control-input"
                                               value="ECO">
                                        <label class="custom-control-label" for="con_type3">ECO</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>




                    <div class="row">
                        <div class="col-md">
                            <button class="btn btn-primary float-right mx-1 aw-a-button" id="send_month" type="submit"
                                    name="action"
                                    value="send"
                                    onclick="return confirm('Ar tikrai norite išsiųsti mėnesio atsakaitą?')">Generuoti
                                ir
                                išsiųsti
                            </button>
                            <button class="btn btn-secondary float-right mx-1 aw-a-button" id="duplicate" type="submit"
                                    name="action"
                                    value="download">Atsisiųsti XLSX
                            </button>
                        </div>
                    </div>

                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>


@endsection


@section('foot-content')
    <script src="{{ asset('js/consultation-frontend-logic.js') }}" defer></script>
@endsection
