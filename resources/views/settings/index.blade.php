@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-6">
            <h1>Nustatymai</h1>
        </div>
    </div>

    <div class="row pt-3">

        <h3>El. laiškai</h3>

        {!! Form::open(['action' => 'SettingsController@email', 'method' => 'POST']) !!}
        <div class="row">
            <div class="col-md-6 aw-options">
                <label class="aw-tooltip" for="emails" data-toggle="tooltip" data-placement="right" title="Įrašykite el. pašto adresus kurie gaus sistemos siunčiamus el. laiškus.">El. adresai <i class="far fa-question-circle"></i></label>
                {{Form::textarea('emails', \App\Option::where('name', 'emails')->value('value'), ['class' => 'form-control'])}}
            </div>
        </div>
        <div class="row pt-4">
            <div class="col-md-6 aw-options">
                {{Form::label('email_text_new_con', 'Naujos konsultacijos el. laiško tekstas')}}
                {{Form::textarea('email_text_new_con', \App\Option::where('name', 'email_text_new_con')->value('value'), ['class' => 'form-control'])}}
            </div>
            <div class="col-md-6 aw-options">
                {{Form::label('email_text_edited_con', 'Redaguotos konsultacijos el. laiško tekstas')}}
                {{Form::textarea('email_text_edited_con', \App\Option::where('name', 'email_text_edited_con')->value('value'), ['class' => 'form-control'])}}
            </div>
            <div class="col-md-6 aw-options">
                {{Form::label('email_text_month_con', 'Mėnesio ataskaitos el. laiško tekstas')}}
                {{Form::textarea('email_text_month_con', \App\Option::where('name', 'email_text_month_con')->value('value'), ['class' => 'form-control'])}}
            </div>
        </div>

        <div class="row">
            <div class="col-md">
                {{Form::submit('Atnaujinti', ['class'=> 'btn btn-primary float-right'])}}
            </div>
        </div>
    </div>
@endsection
