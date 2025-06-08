<?php

namespace App\Http\Controllers;

use App\Models\Tiers\Tiers;
use App\Services\Bridges\Api;
use App\Services\Search;

class TestController extends Controller
{
    public function __invoke()
    {
        dd(Api::getProvidersToSelect());
    }
}
