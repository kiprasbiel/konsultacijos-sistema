@extends('layouts.app')

@section('head-content')
@endsection

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

    {{--    Paieska--}}
    @include('inc.search', ['controller' => 'consultation_search'])

    @if(count($consultations)>0)
        <table class="table">
            <thead>
            <tr>
                <th scope="col">@sortablelink('id', '#')</th>
                <th scope="col">@sortablelink('client.name', 'Įmonės pavadinimas')</th>
                <th scope="col">Kontaktai</th>
                <th scope="col">@sortablelink('theme.name', 'Tema')</th>
                <th scope="col">Adresas</th>
                <th scope="col">@sortablelink('consultation_date', 'Konsultacijos data')</th>
                <th scope="col">@sortablelink('consultation_length', 'Konsultacijos trukmė')</th>
                <th scope="col">Metodas</th>
                <th scope="col">@sortablelink('is_paid', 'Apmokėta?')</th>
                <th scope="col">@sortablelink('is_sent', 'Išsiųsta?')</th>
                <th scope="col"></th>
            </tr>
            </thead>
            <tbody>
            @foreach($consultations as $consultation)
                <tr>
                    <th scope="row">{{$consultation->id}}</th>
                    <td>{{$consultation->client->name}}</td>
                    <td style="{{\App\Http\Controllers\ConsultationController::color_index_table($consultation->id, 'contacts')}}">{{$consultation->contacts}}</td>
                    <td>{{$consultation->theme->name}}</td>
                    <td style="{{\App\Http\Controllers\ConsultationController::color_index_table($consultation->id, 'address')}}">{{$consultation->address}}</td>
                    <td style="{{\App\Http\Controllers\ConsultationController::color_index_table($consultation->id, 'consultation_date')}}">{{$consultation->consultation_date}}</td>
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
                            <a href="/konsultacijos/{{$consultation->id}}/edit" data-toggle="tooltip"
                               data-placement="top" title="Redaguoti konsultaciją">
                                <span class="icons">
                                    <i class="far fa-edit"></i>
                                </span>
                            </a>
                            {{Form::open(['action' => ['ConsultationController@destroy', $consultation->id], 'method' => 'POST'])}}
                            {{Form::hidden('_method', 'DELETE')}}
                            {{Form::button('<i class="fa fa-trash"></i>', ['type' => 'submit', 'class' => 'btn aw-trash-button', 'data-toggle' => 'tooltip', 'data-placement' => 'top', 'title' => 'Ištrinti konsultaciją', 'onclick' => "return confirm('Ar tikrai norite ištrinti konsultaciją?')"])}}
                            {{Form::close()}}
                        </div>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        {!! $consultations->appends(\Request::except('page'))->render() !!}
    @else
        <p>Konsultacijų nerasta</p>
    @endif


@endsection

@section('foot-content')
@endsection
