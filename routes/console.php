<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

foreach (\App\Models\Core\BanqueAggregate::all() as $banque) {
    Schedule::job(new \App\Jobs\Core\AggregateBankMouvement($banque))->hourly();
};
