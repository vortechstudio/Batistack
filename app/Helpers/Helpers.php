<?php

namespace App\Helpers;

class Helpers
{
    public static function mainMenuLabel(string $type = 'name')
    {
        $mainmenu = cache('mainmenu'); // Format attendu: "key: someKey|value: searchValue"
        $configModule = collect(config('modules'))->toArray();

        foreach ($configModule as $module) {
            if(isset($module['slug']) && $module['slug'] == $mainmenu) {
                return $module[$type];
            }
        }
    }

    public static function actualMenuLabel(string $type = 'title')
    {
        $actualmenu = cache('actualmenu');
        $configModule = collect(config('modules'))->toArray();

        foreach ($configModule as $module) {
            foreach ($module['submenus'] as $submenu) {
                if(isset($submenu['slug']) && $submenu['slug'] == $actualmenu) {
                    return $submenu[$type];
                }
            }
        }
    }

    public static function eur(string|int|float $number): string
    {
        return number_format($number, 2, ',', ' ')." €";
    }
}
