@extends('layouts.app')



@section('content')

    <div class="row">
        <div class="col-md-6">
            <h1>Konsultacijos</h1>
        </div>
        <div class="col-md-6">
            <a href="/konsultacijos/create" class="btn btn-primary float-right mx-1">Kurti naują konsultaciją</a>
            <a href="/review" class="btn btn-success float-right mx-1">Generuoti ir išsiųsti <span
                    class="badge badge-light">{{$unsent}}</span></a>
        </div>
    </div>

    @if(count($consultations)>0)
        <table class="table">
            <thead>
            <tr>
                <th scope="col">@sortingLink(['column' => 'id', 'column_name' => '#', 'sort' => $column_sort])
                    @endsortingLink
                </th>
                <th scope="col">@sortingLink(['column' => 'client.name', 'column_name' => 'Įmonės pavadinimas', 'sort'
                    => $column_sort]) @endsortingLink
                </th>
                <th scope="col">@sortingLink(['column' => 'user.name', 'column_name' => 'Konsultantas', 'sort' =>
                    $column_sort]) @endsortingLink
                </th>
                <th scope="col">Kontaktai</th>
                <th scope="col">@sortingLink(['column' => 'theme.name', 'column_name' => 'Tema', 'sort' =>
                    $column_sort]) @endsortingLink
                </th>
                <th scope="col">Adresas</th>
                <th scope="col">@sortingLink(['column' => 'consultation_date', 'column_name' => 'Konsultacijos data',
                    'sort' => $column_sort]) @endsortingLink
                </th>
                <th scope="col">Konsultacijos laikas</th>
                <th scope="col">Konsultacijos trukmė</th>
                <th scope="col">@sortingLink(['column' => 'method', 'column_name' => 'Metodas', 'sort' => $column_sort])
                    @endsortingLink
                </th>
                <th scope="col">@sortingLink(['column' => 'is_paid', 'column_name' => 'Apmokėta?', 'sort' =>
                    $column_sort]) @endsortingLink
                </th>
                <th scope="col">@sortingLink(['column' => 'is_sent', 'column_name' => 'Išsiųsta?', 'sort' =>
                    $column_sort]) @endsortingLink
                </th>
                <th scope="col">
                    <a class="btn" data-toggle="collapse" href="#searchArea" role="button" aria-expanded="false"
                       aria-controls="searchArea">
                        <i class="fas fa-search aw-search-plus" data-toggle="tooltip" data-placement="right"
                           title="Išplėsti paieškos lauką"></i>
                    </a>
                </th>
            </tr>
            <tr class="search-area collapse @if(isset($table_search_model) && isset($table_search_column) && isset($table_search)) show @endif"
                id="searchArea">
                <th class="align-middle"><a href="/konsultacijos"><i class="fas fa-times aw-reload-page"></i></a></th>
                <th scope="col">@include('inc.search', ['model' => 'Consultation', 'column' => 'client.name'])</th>
                <th scope="col">@include('inc.search', ['model' => 'Consultation', 'column' => 'user.name'])</th>
                <th scope="col">@include('inc.search', ['model' => 'Consultation', 'column' => 'contacts'])</th>
                <th scope="col">@include('inc.search', ['model' => 'Consultation', 'column' => 'theme.name'])</th>
                <th scope="col">@include('inc.search', ['model' => 'Consultation', 'column' => 'address'])</th>
                <th scope="col">@include('inc.search', ['model' => 'Consultation', 'column' => 'consultation_date'])</th>
                <th scope="col">@include('inc.search', ['model' => 'Consultation', 'column' => 'consultation_time'])</th>
                <th scope="col">@include('inc.search', ['model' => 'Consultation', 'column' => 'consultation_length'])</th>
                <th scope="col">@include('inc.search', ['model' => 'Consultation', 'column' => 'method'])</th>
                <th scope="col"></th>
                <th scope="col"></th>
                <th class="align-middle text-center"><i class="far fa-question-circle aw-question-circle"
                                                        data-toggle="tooltip" data-placement="right"
                                                        title="Įveskite į vieną iš laukelių paieškos raktažodį ir spauskite ENTER"></i>
                </th>
            </tr>
            </thead>
            <tbody>
            @foreach($consultations as $consultation)
                <tr>
                    <th scope="row">{{$consultation->id}}</th>
                    <td>{{$consultation->client->name}}</td>
                    <td>{{$consultation->user->name}}</td>
                    <td style="{{\App\Http\Controllers\ConsultationController::color_index_table($consultation->id, 'contacts')}}">{{$consultation->contacts}}</td>
                    <td>{{$consultation->theme->name}}</td>
                    <td style="{{\App\Http\Controllers\ConsultationController::color_index_table($consultation->id, 'address')}}">{{$consultation->address}}</td>
                    <td style="{{\App\Http\Controllers\ConsultationController::color_index_table($consultation->id, 'consultation_date')}}">{{$consultation->consultation_date}}</td>
                    <td style="{{\App\Http\Controllers\ConsultationController::color_index_table($consultation->id, 'consultation_time')}}">{{$consultation->consultation_time}}</td>
                    <td style="{{\App\Http\Controllers\ConsultationController::color_index_table($consultation->id, 'consultation_length')}}">{{$consultation->consultation_length}}</td>
                    <td style="{{\App\Http\Controllers\ConsultationController::color_index_table($consultation->id, 'method')}}">{{$consultation->method}}</td>
                    <td>
                        @if ($consultation->is_paid==1)
                            <span class="icons"><i class="far fa-money-bill-alt paid"></i></span>
                        @else
                            <span class="icons"><i class="far fa-money-bill-alt not-paid"></i></span>
                        @endif
                    </td>
                    <td>
                        @if ($consultation->is_sent==1)
                            Taip
                        @else
                            Ne
                        @endif

                        @if($consultation->consultation_meta->where('type', 'draft_changes')->first())
                            <br><strong>Redaguota</strong>
                        @endif
                    </td>
                    <td>
                        <div class="d-inline-flex">
                            <a class="btn aw-bars-button" href="/konsultacijos/{{$consultation->id}}">
                                <span class="icons">
                                    <i class="fas fa-bars aw-bars"></i>
                                </span>
                            </a>
                            <a href="/konsultacijos/{{$consultation->id}}/edit" data-toggle="tooltip"
                               data-placement="top" title="Redaguoti konsultaciją">
                                <span class="icons">
                                    <i class="far fa-edit"></i>
                                </span>
                            </a>
                            {{Form::open(['action' => ['ConsultationController@destroy', $consultation->id], 'method' => 'POST'])}}
                            {{Form::hidden('_method', 'DELETE')}}
                            {{Form::button('<i class="fa fa-trash"></i>', ['type' => 'submit', 'class' => 'btn aw-trash-button', 'data-toggle' => 'tooltip', 'data-placement' => 'top', 'title' => 'Ištrinti konsultaciją', 'onclick' => "return confirm('Ar tikrai norite ištrinti konsultaciją? Jei konsultacija dar nepraėjusi ir išsiųsta - bus išsiųsta atąskaita.')"])}}
                            {{Form::close()}}
                        </div>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>

        @if(isset($pagination_column) && isset($pagination_sort))
            {{ $consultations->appends(['column' => $pagination_column, 'sort'=>$pagination_sort])->links() }}
        @elseif(isset($table_search_model) && isset($table_search_column) && isset($table_search))
            {{ $consultations->appends(['model' => $table_search_model, 'column'=>$table_search_column, 'search' => $table_search])->links() }}
        @else
            {{$consultations->links()}}
        @endif

    @else
        <p>Konsultacijų nerasta</p>
    @endif


@endsection
