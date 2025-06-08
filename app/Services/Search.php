<?php

namespace App\Services;

use Vicopo\Vicopo;

class Search
{
    public static function searchCityByCode(string|null $code_postal = '44000')
    {
        $search = Vicopo::https($code_postal);
        return collect($search)
            ->pluck('cities')
            ->flatten(1)
            ->pluck('city')
            ->mapWithKeys(fn ($city) => [$city => $city])
            ->toArray();
    }
}
