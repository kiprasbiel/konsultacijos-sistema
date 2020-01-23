<?php


namespace App\CustomClasses;


use App\Option;

class TableSort
{
    private $pagination_int;

    public function __construct() {
        $this->pagination_int = Option::where('name', 'pagination_per_page')->value('value');
    }

    public function sort_model($model_main, $column, $column_sort, $additional_where){


        $className = 'App\\'.$model_main;

        if (strpos($column, '.') !== false){
            $column_explode = explode('.', $column);
            $model_realtion = $column_explode[0];
//            dd($model_realtion.'s.id');
            $model_realtion_column = $column_explode[1];
            if (!empty($additional_where)){
                $consultations = $className::leftJoin($model_realtion.'s', strtolower($model_main).'s.' . $model_realtion .'_id', '=', $model_realtion.'s.id')
                    ->select(strtolower($model_main).'s.*')
                    ->where(array_key_first($additional_where), $additional_where[array_key_first($additional_where)])
                    ->orderBy($model_realtion.'s.'.$model_realtion_column, $column_sort)
                    ->paginate($this->pagination_int);
            }
            else{
                $consultations = $className::leftJoin($model_realtion.'s', strtolower($model_main).'s.' . $model_realtion .'_id', '=', $model_realtion.'s.id')
                    ->select(strtolower($model_main).'s.*')
                    ->orderBy($model_realtion.'s.'.$model_realtion_column, $column_sort)
                    ->paginate($this->pagination_int);
            }
        }
        else{
            $consultations = $className::orderBy($column, $column_sort)->paginate($this->pagination_int);
        }

        return $consultations;

    }

    public function sort_toggle($column_sort){
        //Toggling sorting link
        if ($column_sort == 'desc') {
            $column_sort = 'asc';
        } else {
            $column_sort = 'desc';
        }

        return $column_sort;
    }


}
