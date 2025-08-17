<?php

use App\Models\Module\Core\Setting;
use Illuminate\Database\Eloquent\Factories\HasFactory;

it('uses the HasFactory trait', function () {
    /**
     * @runInSeparateProcess
     */
    $uses = class_uses(Setting::class);
    expect($uses)->toContain(HasFactory::class);
});

it('has guarded property set to empty array', function () {
    $setting = new Setting();
    expect($setting->getGuarded())->toBe([]);
});

it('has casts property for expired_at', function () {
    $setting = new Setting();
    expect($setting->getCasts())->toHaveKey('expired_at');
    expect($setting->getCasts()['expired_at'])->toBe('date');
});
