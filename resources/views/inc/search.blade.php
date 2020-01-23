<div class="row">
    <div class="col">
        {{Form::open(['action' => [$model.'Controller@display_table_search_results'], 'method' => 'GET'])}}
            <input type="hidden" name="model" value="{{$model}}">
            <input type="hidden" name="column" value="{{$column}}">
            {{Form::text('search',  '', ['class' => 'form-control', 'id' => $column ])}}
        {{Form::close()}}
    </div>
</div>
