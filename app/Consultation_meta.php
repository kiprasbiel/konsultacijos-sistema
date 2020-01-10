<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Consultation_meta extends Model
{
    public function consultation(){
        return $this->belongsTo(Consultation::class);
    }
}
