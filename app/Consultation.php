<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class Consultation extends Model
{
    use Sortable;

    public $sortable = [
        'id',
        'name',
        'consultation_date',
        'consultation_length',
        'is_paid',
        'is_sent',
    ];

    public function client(){
        return $this->belongsTo(Client::class);
    }
    public function theme(){
        return $this->belongsTo(Theme::class);
    }
    public function user(){
        return $this->belongsTo(User::class);
    }
    public function consultation_meta(){
        return $this->hasMany(Consultation_meta::class);
    }
}
