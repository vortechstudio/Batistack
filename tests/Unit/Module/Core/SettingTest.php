<?php

use App\Models\Module\Core\Setting;
use Illuminate\Database\Eloquent\Factories\HasFactory;

it('uses the HasFactory trait', function () {
    $uses = class_uses_recursive(Setting::class);
    expect($uses)->toContain(HasFactory::class);
});

it('has guarded property set to empty array', function () {
    $setting = new Setting();
    $reflection = new ReflectionClass($setting);
    $property = $reflection->getProperty('guarded');
    $property->setAccessible(true);
    expect($property->getValue($setting))->toBe([]);
});

it('has casts property for expired_at', function () {
    $setting = new Setting();
    $casts = $setting->getCasts();
    expect($casts)->toHaveKey('expired_at');
    expect($casts['expired_at'])->toBe('date');
});

it('can be instantiated', function () {
    $setting = new Setting();
    expect($setting)->toBeInstanceOf(Setting::class);
});
