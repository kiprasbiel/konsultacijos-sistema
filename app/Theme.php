<?php

namespace App;

use App\CustomClasses\ThemeClass;
use Illuminate\Database\Eloquent\Model;

class Theme extends Model
{
    public static function get_theme_ids_by_main_theme($main_theme){
        return ThemeClass::get_themes_by_main_theme_arr($main_theme);
    }

    public function consultation(){
        return $this->hasMany(Consultation::class);
    }
}
