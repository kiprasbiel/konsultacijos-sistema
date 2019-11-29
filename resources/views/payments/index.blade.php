@extends('layouts.app')

@section('head-content')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/css/select2.min.css" rel="stylesheet"/>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css"/>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-4">
            <h1>Apmokėjimai</h1>
        </div>
    </div>

    {!! Form::open(['action' => 'PaymentController@update', 'method' => 'POST']) !!}

    <div class="row">
        <div class="col-md-4">
            <div class="form-group">
                {{Form::label('company_id', 'Įmonės pavadinimas')}}
                {{Form::select('company_id', [], null, ['class' => 'form-control select2 company_id', 'id' => 'company_id'])}}
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                {{Form::label('period', 'Laikotarpis')}}
                {{Form::text('period', '', ['class' => 'form-control'])}}
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                {{Form::label('payment_date', 'Apmokėjimo data')}}
                {{Form::date('payment_date', \Carbon\Carbon::now(), ['class' => 'form-control'])}}
            </div>
        </div>

    </div>
    <div class="row">
        <div class="col-md-4">
            <div class="form-group">
                {{Form::label('is_payed', 'Ar apmokėta?')}}
                <div class="custom-control custom-radio">
                    <input value="1" type="radio" id="paid" name="is_paid" class="custom-control-input" checked>
                    <label class="custom-control-label" for="paid">Apmokėta</label>
                </div>
                <div class="custom-control custom-radio">
                    <input value="0" type="radio" id="not_paid" name="is_paid" class="custom-control-input">
                    <label class="custom-control-label" for="not_paid">Neapmokėta</label>
                </div>
            </div>
        </div>

    </div>

    {{Form::hidden('_method', 'PUT')}}

    <div class="row">
        <div class="col-md">
            <button class="btn btn-primary float-right mx-1" type="submit" name="action">Išsaugoti</button>
        </div>
    </div>

    {!! Form::close() !!}
@endsection

@section('foot-content')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/js/select2.min.js"></script>
    <script src="{{ asset('js/consultation-frontend-logic.js') }}" defer></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>

    <script>
        jQuery(document).ready(function ($) {
            $('input[name="period"]').daterangepicker({
                    opens: 'left',
                    locale: {
                        format: 'YYYY-MM-DD',
                    }
                },
            );
        });

    </script>
@endsection