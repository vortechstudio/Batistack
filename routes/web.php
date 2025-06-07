<?php

use Illuminate\Support\Facades\Route;


Route::get('/auth/{provider}/redirect', [\App\Http\Controllers\AuthController::class, 'redirect'])->name('social.redirect');
Route::get('/auth/{provider}/callback', [\App\Http\Controllers\AuthController::class, 'callback'])->name('social.callback');

Route::post('/upload', [\App\Http\Controllers\UploadController::class, 'store'])->name('upload');

Route::middleware(['auth'])->group(function () {
    Route::get('/', \App\Livewire\Core\Dashboard::class)->name('dashboard');
    Route::get('/core/dashboard', \App\Livewire\Core\Dashboard::class)->name('core.dashboard');
    Route::get('/core/settings/company', \App\Livewire\Core\SettingCompany::class)->name('core.settings.company');
});
