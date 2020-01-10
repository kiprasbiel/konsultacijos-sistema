<?php
$role = ['2' => 'Konsultantas', '1' => 'Administratorius'];
?>
@extends('layouts.app')

@section('head-content')
@endsection

@section('content')
    <div class="container">
        <div class="row">
            <div class="col">
                <h1>Redaguoti vartotoją <strong>{{$user->name}}</strong></h1>
            </div>
        </div>
        {!! Form::open(['action' => ['UserController@update', $user->id], 'method' => 'POST']) !!}
        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    {{Form::label('username', 'Prisijungimo vardas')}}
                    {{Form::text('username', $user->username, ['class' => 'form-control'])}}
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    {{Form::label('name', 'Vardas ir pavardė')}}
                    {{Form::text('name', $user->name, ['class' => 'form-control'])}}
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    {{Form::label('role', 'Pareigos')}}
                    {{Form::select('role', $role, $user->role, ['class' => 'form-control', 'placeholder' => "Parinkite vartotojui pareigas"])}}
                </div>
            </div>
        </div>

        <div class="row pt-3">
                <div class="col-md-4">
                    <div class="form-group">
                        {{Form::label('password', 'Slaptažodis')}}
                        <input type="password" name="password"  class="form-control" autocomplete="new-password"/>

                        {{Form::label('password_confirmation', 'Patvirtinkite slaptažodį')}}
                        <input type="password" name="password_confirmation" class="form-control" autocomplete="new-password"/>
                    </div>
                </div>
        </div>

        {{Form::hidden('_method', 'PUT')}}

        <div class="row">
            <div class="col-md">
                <button class="btn btn-primary float-right mx-1 aw-a-button" type="submit" name="action">Išsaugoti</button>
            </div>
        </div>

        {!! Form::close() !!}
    </div>


@endsection

@section('foot-content')
@endsection
