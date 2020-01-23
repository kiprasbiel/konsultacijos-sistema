<?php


namespace App\CustomClasses;


use App\Option;

class SearchTableColumns
{
    private $pagination_int;

    public function __construct() {
        $this->pagination_int = Option::where('name', 'pagination_per_page')->value('value');
    }

    public function tableSearchColumn($model, $column, $search_input){

        $className = 'App\\'.$model;

        if (strpos($column, '.') !== false){
            $column_explode = explode('.', $column);
            $model_realtion = $column_explode[0];
            $model_realtion_column = $column_explode[1];

            $model_list = $className::whereHas($model_realtion, function ($query) use ($model_realtion_column, $search_input){
                $query->where($model_realtion_column, 'like', "%{$search_input}%");
            })->orderBy('id', 'desc')->paginate($this->pagination_int);
        }
        else{
            $model_list = $className::where($column, 'like', "%{$search_input}%")->orderBy('id', 'desc')->paginate($this->pagination_int);
        }
        return $model_list;
    }
}
