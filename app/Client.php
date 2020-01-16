<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class Client extends Model
{
    use Sortable;

    public $sortable = [
        'id',
        'name',
        'code',
        'company_reg_date',
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }
    public function consultations(){
        return $this->hasMany(Consultation::class);
    }
}
