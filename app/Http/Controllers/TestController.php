<?php

namespace App\Http\Controllers;

use App\Services\Search;

class TestController extends Controller
{
    public function __invoke()
    {
        $search = new Search();
        dd($search->searchCityByCode(44190));
    }
}
