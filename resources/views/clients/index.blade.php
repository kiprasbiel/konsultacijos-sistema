<?php
$county_list = ["akmenes-r" => "Akmenės r.", "alytaus-m" => "Alytaus m.", "alytaus-r" => "Alytaus r.", "anyksciu-r" => "Anykščių r.", "birstono" => "Birštono", "birzu-r" => "Biržų r.", "druskininku" => "Druskininkų", "elektrenu" => "Elektrėnų", "ignalinos-r" => "Ignalinos r.", "jonavos-r" => "Jonavos r.", "joniskio-r" => "Joniškio r.", "jurbarko-r" => "Jurbarko r.", "kaisiadoriu-r" => "Kaišiadorių r.", "kalvarijos" => "Kalvarijos", "kauno-m" => "Kauno m.", "kauno-r" => "Kauno r.", "kazlu-rudos" => "Kazlų Rūdos", "kelmes-r" => "Kelmės r.", "kedainiu-r" => "Kėdainių r.", "klaipedos-m" => "Klaipėdos m.", "klaipedos-r" => "Klaipėdos r.", "kretingos-r" => "Kretingos r.", "kupiskio-r" => "Kupiškio r.", "lazdiju-r" => "Lazdijų r.", "marijampoles" => "Marijampolės", "mazeikiu-r" => "Mažeikių r.", "moletu-r" => "Molėtų r.", "neringos" => "Neringos", "pagegiu" => "Pagėgių", "pakruojo-r" => "Pakruojo r.", "palangos-m" => "Palangos m.", "panevezio-m" => "Panevėžio m.", "panevezio-r" => "Panevėžio r.", "pasvalio-r" => "Pasvalio r.", "plunges-r" => "Plungės r.", "prienu-r" => "Prienų r.", "radviliskio-r" => "Radviliškio r.", "raseiniu-r" => "Raseinių r.", "rietavo" => "Rietavo", "rokiskio-r" => "Rokiškio r.", "skuodo-r" => "Skuodo r.", "sakiu-r" => "Šakių r.", "salcininku-r" => "Šalčininkų r.", "siauliu-m" => "Šiaulių m.", "siauliu-r" => "Šiaulių r.", "silales-r" => "Šilalės r.", "silutes-r" => "Šilutės r.", "sirvintu-r" => "Širvintų r.", "svencioniu-r" => "Švenčionių r.", "taurages-r" => "Tauragės r.", "telsiu-r" => "Telšių r.", "traku-r" => "Trakų r.", "ukmerges-r" => "Ukmergės r.", "utenos-r" => "Utenos r.", "varenos-r" => "Varėnos r.", "vilkaviskio-r" => "Vilkaviškio r.", "vilniaus-m" => "Vilniaus m.", "vilniaus-r" => "Vilniaus r.", "visagino-m" => "Visagino m.", "zarasu-r" => "Zarasų r."];
?>

@extends('layouts.app')

@section('content')

    <div class="row">
        <div class="col-md-6">
            <h1>Klientai</h1>
        </div>
        <div class="col-md-6">
            <a href="/klientai/create" class="btn btn-success float-right">Kurti naują klientą</a>
        </div>
    </div>

    @if(count($clients)>0)
        <table class="table">
            <thead>
            <tr>
                <th scope="col">@sortingLink(['model' => 'Client', 'column' => 'id', 'column_name' => '#', 'sort' => $column_sort])
                    @endsortingLink
                </th>
                <th scope="col">@sortingLink(['model' => 'Client', 'column' => 'name', 'column_name' => 'Pavadinimas', 'sort' =>
                    $column_sort]) @endsortingLink
                </th>
                <th scope="col">Įm. kodas</th>
                <th scope="col">@sortingLink(['model' => 'Client', 'column' => 'company_reg_date', 'column_name' => 'Reg. data', 'sort' =>
                    $column_sort]) @endsortingLink
                </th>
                <th scope="col">Reg. apskritis</th>
                <th scope="col">Konsultacijų tipas</th>
                <th scope="col">@sortingLink(['model' => 'Client', 'column' => 'user.name', 'column_name' => 'Sukūrė', 'sort' =>
                    $column_sort]) @endsortingLink
                </th>
                <th scope="col">Kontaktai</th>
                <th scope="col">
                    <a class="btn" data-toggle="collapse" href="#searchArea" role="button" aria-expanded="false"
                       aria-controls="searchArea">
                        <i class="fas fa-search aw-search-plus" data-toggle="tooltip" data-placement="right" title="Išplėsti paieškos lauką"></i>
                    </a>
                </th>
            </tr>

            <tr class="search-area collapse @if(isset($table_search_model) && isset($table_search_column) && isset($table_search)) show @endif" id="searchArea">
                <th class="align-middle"><a href="/klientai"><i class="fas fa-times aw-reload-page"></i></a></th>
                <th scope="col">@include('inc.search', ['model' => 'Client', 'column' => 'name'])</th>
                <th scope="col">@include('inc.search', ['model' => 'Client', 'column' => 'code'])</th>
                <th scope="col">@include('inc.search', ['model' => 'Client', 'column' => 'company_reg_date'])</th>
                <th scope="col"></th>
                <th scope="col"></th>
                <th scope="col">@include('inc.search', ['model' => 'Client', 'column' => 'user.name'])</th>
                <th scope="col">@include('inc.search', ['model' => 'Client', 'column' => 'contacts'])</th>
                <th class="align-middle text-center"><i class="far fa-question-circle aw-question-circle" data-toggle="tooltip" data-placement="right" title="Įveskite į vieną iš laukelių paieškos raktažodį ir spauskite ENTER"></i></th>
            </tr>

            </thead>
            <tbody>
            @foreach($clients as $client)
                <tr>
                    <th scope="row">{{$client->id}}</th>
                    <td>{{$client->name}}</td>
                    <td>{{$client->code}}</td>
                    <td>{{$client->company_reg_date}}</td>
                    <td>{{$county_list[$client->reg_county]}}</td>
                    <td>
                        @if (!is_null($client->vkt))
                            VKT
                        @endif
                        @if (!is_null($client->expo))
                            EXPO
                        @endif
                        @if (!is_null($client->eco))
                            ECO
                        @endif
                    </td>
                    <td>{{$client->user->name}}</td>
                    <td>{{$client->contacts}}</td>
                    <td>
                        <div class="d-inline-flex">
                            <a href="/klientai/{{$client->id}}/edit" data-toggle="tooltip"
                               data-placement="top" title="Redaguoti klientą">
                                <span class="icons">
                                    <i class="far fa-edit"></i>
                                </span>
                            </a>
                            {{Form::open(['action' => ['ClientController@destroy', $client->id], 'method' => 'POST'])}}
                            {{Form::hidden('_method', 'DELETE')}}
                            {{Form::button('<i class="fa fa-trash"></i>', ['type' => 'submit', 'class' => 'btn aw-trash-button', 'data-toggle' => 'tooltip', 'data-placement' => 'top', 'title' => 'Ištrinti klientą', 'onclick' => "return confirm('Ištrinant klientą bus ištrintos ir visos jo konsultacijos. Ar tikrai norite ištrinti klientą?')"])}}
                            {{Form::close()}}
                        </div>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        @if(isset($pagination_column) && isset($pagination_sort))
            {{ $clients->appends(['column' => $pagination_column, 'sort'=>$pagination_sort])->links() }}
        @elseif(isset($table_search_model) && isset($table_search_column) && isset($table_search))
            {{ $clients->appends(['model' => $table_search_model, 'column'=>$table_search_column, 'search' => $table_search])->links() }}
        @else
            {{$clients->links()}}
        @endif
    @else
        <p>Klientų nerasta</p>
    @endif

@endsection
