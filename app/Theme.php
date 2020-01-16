<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class Theme extends Model
{
    use Sortable;

    public $sortable = [
        'id',
        'name',
        'main_theme',
        'theme_number',
        'type',
        'min_old',
        'max_old',
    ];

    public function consultation(){
        return $this->hasMany(Consultation::class);
    }
}
