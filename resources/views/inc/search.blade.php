<div class="row flex-row-reverse">
    <div class="col-md-4 pb-2">
        {{Form::open(['action' => ['SearchController@'.$controller], 'method' => 'GET'])}}
            {{Form::text('paieska', request()->input('paieska'), ['class' => 'form-control', 'placeholder' => 'Paieska'])}}
        {{Form::close()}}
    </div>
</div>