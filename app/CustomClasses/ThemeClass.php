<?php


namespace App\CustomClasses;


use App\Theme;

class ThemeClass
{
    public static function get_themes_by_main_theme_arr($main_theme){
        $themes = Theme::where('main_theme', $main_theme)->get('id')->toArray();
        $themes_val = [];
        foreach ($themes as $theme){
            $themes_val[] = array_values($theme)[0];
        }
        return $themes_val;
    }
}
