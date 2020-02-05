@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-6">
            <h1>Nustatymai</h1>
        </div>
    </div>
    <h3 class="pt-4">El. laiškai</h3>
    <div class="row pt-3">
        {!! Form::open(['action' => 'SettingsController@set_options', 'method' => 'POST']) !!}
        <div class="row">
            <div class="col-md-6 aw-options">
                <label class="aw-tooltip" for="emails" data-toggle="tooltip" data-placement="right" title="Įrašykite el. pašto adresus kurie gaus sistemos siunčiamus el. laiškus.">El. adresai <i class="far fa-question-circle"></i></label>
                {{Form::textarea('emails', \App\Option::where('name', 'emails')->value('value'), ['class' => 'form-control'])}}
            </div>
        </div>
        <div class="row pt-4">
            <div class="col-md-6 aw-options pt-2">
                {{Form::label('email_text_new_con', 'Naujos konsultacijos el. laiško tekstas')}}
                {{Form::textarea('email_text_new_con', \App\Option::where('name', 'email_text_new_con')->value('value'), ['class' => 'form-control'])}}
            </div>
            <div class="col-md-6 aw-options pt-2">
                {{Form::label('email_text_edited_con', 'Redaguotos konsultacijos el. laiško tekstas')}}
                {{Form::textarea('email_text_edited_con', \App\Option::where('name', 'email_text_edited_con')->value('value'), ['class' => 'form-control'])}}
            </div>
            <div class="col-md-6 aw-options pt-2">
                {{Form::label('email_text_delete_con', 'Ištrintos konsultacijos el. laiško tekstas')}}
                {{Form::textarea('email_text_delete_con', \App\Option::where('name', 'email_text_delete_con')->value('value'), ['class' => 'form-control'])}}
            </div>
            <div class="col-md-6 aw-options pt-2">
                {{Form::label('email_text_month_con', 'Mėnesio ataskaitos el. laiško tekstas')}}
                {{Form::textarea('email_text_month_con', \App\Option::where('name', 'email_text_month_con')->value('value'), ['class' => 'form-control'])}}
            </div>
        </div>
        <hr>
        <h3 class="pt-4">Sąrašai</h3>
        <div class="row pt-2">
            <div class="col-md-2 aw-options pt-2">
                {{Form::label('pagination_per_page', 'Elementų skaičius sąrašuose')}}
                {{Form::text('pagination_per_page', \App\Option::where('name', 'pagination_per_page')->value('value'), ['class' => 'form-control'])}}
            </div>
        </div>

        <div class="row">
            <div class="col-md pt-4">
                {{Form::submit('Atnaujinti', ['class'=> 'btn btn-primary float-right'])}}
            </div>
        </div>
        {!! Form::close() !!}
    </div>
@endsection
