{{Form::open(['action' => [$model.'Controller@list_sort'], 'method' => 'POST'])}}
<input type="hidden" name="model" value="{{$model}}">
<input type="hidden" name="column" value="{{$column}}">
<input type="hidden" name="sort" value="{{$sort}}">
{{Form::submit($column_name, ['class'=> 'btn'])}}
{{Form::close()}}


{{--<a href="?column={{$column}}&sort={{$sort}}">{{$column_name}}</a>--}}


