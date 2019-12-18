@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-6">
            <h1>Nustatymai</h1>
        </div>
    </div>

    {!! Form::open(['action' => 'SettingsController@email', 'method' => 'POST']) !!}
    <div class="row">
        <div class="col-md-6 aw-options">
            {{Form::label('emails', 'El. laiškai')}}
            {{Form::textarea('emails', \App\Option::where('name', 'emails')->value('value'), ['class' => 'form-control'])}}
        </div>
    </div>
    <div class="row">
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
@endsection
