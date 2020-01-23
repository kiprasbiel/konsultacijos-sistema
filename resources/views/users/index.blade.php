<?php
$county_list = ["akmenes-r" => "Akmenės r.", "alytaus-m" => "Alytaus m.", "alytaus-r" => "Alytaus r.", "anyksciu-r" => "Anykščių r.", "birstono" => "Birštono", "birzu-r" => "Biržų r.", "druskininku" => "Druskininkų", "elektrenu" => "Elektrėnų", "ignalinos-r" => "Ignalinos r.", "jonavos-r" => "Jonavos r.", "joniskio-r" => "Joniškio r.", "jurbarko-r" => "Jurbarko r.", "kaisiadoriu-r" => "Kaišiadorių r.", "kalvarijos" => "Kalvarijos", "kauno-m" => "Kauno m.", "kauno-r" => "Kauno r.", "kazlu-rudos" => "Kazlų Rūdos", "kelmes-r" => "Kelmės r.", "kedainiu-r" => "Kėdainių r.", "klaipedos-m" => "Klaipėdos m.", "klaipedos-r" => "Klaipėdos r.", "kretingos-r" => "Kretingos r.", "kupiskio-r" => "Kupiškio r.", "lazdiju-r" => "Lazdijų r.", "marijampoles" => "Marijampolės", "mazeikiu-r" => "Mažeikių r.", "moletu-r" => "Molėtų r.", "neringos" => "Neringos", "pagegiu" => "Pagėgių", "pakruojo-r" => "Pakruojo r.", "palangos-m" => "Palangos m.", "panevezio-m" => "Panevėžio m.", "panevezio-r" => "Panevėžio r.", "pasvalio-r" => "Pasvalio r.", "plunges-r" => "Plungės r.", "prienu-r" => "Prienų r.", "radviliskio-r" => "Radviliškio r.", "raseiniu-r" => "Raseinių r.", "rietavo" => "Rietavo", "rokiskio-r" => "Rokiškio r.", "skuodo-r" => "Skuodo r.", "sakiu-r" => "Šakių r.", "salcininku-r" => "Šalčininkų r.", "siauliu-m" => "Šiaulių m.", "siauliu-r" => "Šiaulių r.", "silales-r" => "Šilalės r.", "silutes-r" => "Šilutės r.", "sirvintu-r" => "Širvintų r.", "svencioniu-r" => "Švenčionių r.", "taurages-r" => "Tauragės r.", "telsiu-r" => "Telšių r.", "traku-r" => "Trakų r.", "ukmerges-r" => "Ukmergės r.", "utenos-r" => "Utenos r.", "varenos-r" => "Varėnos r.", "vilkaviskio-r" => "Vilkaviškio r.", "vilniaus-m" => "Vilniaus m.", "vilniaus-r" => "Vilniaus r.", "visagino-m" => "Visagino m.", "zarasu-r" => "Zarasų r."];
?>

@extends('layouts.app')

@section('content')

    <div class="row">
        <div class="col-md-6">
            <h1>Vartotojai</h1>
        </div>
        <div class="col-md-6">
            <a href="/create-user" class="btn btn-success float-right">Kurti naują vartoją</a>
        </div>
    </div>


    @if(count($users)>0)
        <table class="table">
            <thead>
            <tr>
                <th scope="col">@sortingLink(['column' => 'id', 'column_name' => '#', 'sort' => $column_sort])
                    @endsortingLink
                </th>
                <th scope="col">@sortingLink(['column' => 'name', 'column_name' => 'Vardas', 'sort' => $column_sort])
                    @endsortingLink
                </th>
                <th scope="col">@sortingLink(['column' => 'username', 'column_name' => 'Prisijungimo vardas', 'sort' =>
                    $column_sort]) @endsortingLink
                </th>
                <th scope="col">@sortingLink(['column' => 'created_at', 'column_name' => 'Reg. data', 'sort' =>
                    $column_sort]) @endsortingLink
                </th>
                <th scope="col">@sortingLink(['column' => 'role', 'column_name' => 'Rolė', 'sort' => $column_sort])
                    @endsortingLink
                </th>
                <th scope="col"></th>
            </tr>
            </thead>
            <tbody>
            @foreach($users as $user)
                <tr>
                    <th scope="row">{{$user->id}}</th>
                    <td>{{$user->name}}</td>
                    <td>{{$user->username}}</td>
                    <td>{{$user->created_at}}</td>
                    <td>
                        @if ($user->role == 1)
                            Administratorius
                        @elseif ($user->role == 2)
                            Konsultantas
                        @endif
                    </td>
                    <td>
                        <div class="d-inline-flex">
                            <a href="/vartotojai/{{$user->id}}/edit" data-toggle="tooltip"
                               data-placement="top" title="Redaguoti vartotoją">
                                <span class="icons">
                                    <i class="far fa-edit"></i>
                                </span>
                            </a>

                            <button class="btn aw-trash-button" data-toggle="modal" data-target='#user_destroy_form'
                                    data-id="{{$user->id}}" data-name="{{$user->name}}"
                                    onclick="return confirm('Ar tikrai norite ištrinti vartotoją?')">
                                <i class="fa fa-trash"></i>
                            </button>

                            {{--                            {{Form::open(['action' => ['UserController@destroy', $user->id], 'method' => 'POST'])}}--}}
                            {{--                            {{Form::hidden('_method', 'DELETE')}}--}}
                            {{--                            {{Form::button('<i class="fa fa-trash"></i>', ['type' => 'submit', 'class' => 'btn aw-trash-button', 'data-toggle' => 'modal', 'data-target'=>'#user_destroy_form', 'onclick' => "return confirm('Ištrinant klientą bus ištrintos ir visos jo konsultacijos. Ar tikrai norite ištrinti klientą?')"])}}--}}
                            {{--                            {{Form::close()}}--}}
                        </div>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        {{ $users->appends(['column' => $pagination_column, 'sort'=>$pagination_sort])->links() }}

        {{--        Modal--}}
        <div class="modal fade" id="user_destroy_form" tabindex="-1" role="dialog"
             aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    {{Form::open([ 'method' => 'POST', 'id'=>'user_delete_form'])}}
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalCenterTitle">Pašalinti ...</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div id="modal_description">Pasirinkite, kam priskirti ... konsultacijas:</div>

                        {{Form::select('substitute_id', $consultant_arr, null, ['class' => 'form-control user_id', 'id' => 'substitute_select', 'placeholder' => "Pasirinkite konsultantą"])}}

{{--                        <select name="substitute_id" id="substitute_select">--}}
{{--                            @foreach($consultant_arr as $key=>$consultant)--}}
{{--                                <option value="{{$key}}">{{$consultant}}</option>--}}
{{--                            @endforeach--}}

{{--                            lalalaa--}}
{{--                        </select>--}}
                    </div>
                    <div class="modal-footer">

                        {{Form::hidden('_method', 'DELETE')}}
                        {{Form::button('Pašalinti vartotoją', ['type' => 'submit', 'class' => 'btn btn-danger'])}}

                    </div>
                    {{Form::close()}}
                </div>
            </div>
        </div>

    @else
        <p>Vartotojų nerasta</p>
    @endif

@endsection

@section('foot-content')
@endsection
