<?php

use Illuminate\Support\Facades\Route;


Route::get('/auth/{provider}/redirect', [\App\Http\Controllers\AuthController::class, 'redirect'])->name('social.redirect');
Route::get('/auth/{provider}/callback', [\App\Http\Controllers\AuthController::class, 'callback'])->name('social.callback');
Route::get('/auth/activate/{token}', [\App\Http\Controllers\AuthController::class, 'activate'])->name('auth.activate');
Route::post('/auth/activate', [\App\Http\Controllers\AuthController::class, 'activating'])->name('auth.activating');

Route::post('/upload', [\App\Http\Controllers\UploadController::class, 'store'])->name('upload');
Route::get('/aggregate/callback', \App\Http\Controllers\AggregateController::class);
Route::get('/test', \App\Http\Controllers\TestController::class);

Route::middleware(['auth'])->group(function () {
    Route::get('/', \App\Livewire\Core\Dashboard::class)->name('dashboard');
    Route::get('/core/dashboard', \App\Livewire\Core\Dashboard::class)->name('core.dashboard');
    Route::get('/core/settings/company', \App\Livewire\Core\SettingCompany::class)->name('core.settings.company');
    Route::get('/core/settings/banque', \App\Livewire\Core\SettingBanque::class)->name('core.settings.banque');

    Route::prefix('apps')->group(function () {
        Route::get('call', \App\Livewire\Apps\Calling::class)->name('apps.call');
    });

    Route::prefix('tiers')->group(function () {
        Route::get('dashboard', \App\Livewire\Tiers\Dashboard::class)->name('tiers.dasboard');
        Route::get('fournisseur', \App\Livewire\Tiers\Fournisseur::class)->name('tiers.fournisseur.index');
        Route::get('fournisseur/create', \App\Livewire\Tiers\Fournisseur\Create::class)->name('tiers.fournisseur.create');
        Route::get('fournisseur/{tiers}', \App\Livewire\Tiers\Fournisseur\Show::class)->name('tiers.fournisseur.show');
        Route::get('client', \App\Livewire\Tiers\Dashboard::class)->name('tiers.client.index');
    });
});
