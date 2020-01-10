<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Consultation extends Model
{
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
