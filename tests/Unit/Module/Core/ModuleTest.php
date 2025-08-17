<?php

use App\Models\Module\Core\Module;
use Illuminate\Database\Eloquent\Factories\HasFactory;

it('uses the HasFactory trait', function () {
    $uses = class_uses_recursive(Module::class);
    expect($uses)->toContain(HasFactory::class);
});

it('has guarded property set to empty array', function () {
    $module = new Module();
    $reflection = new ReflectionClass($module);
    $property = $reflection->getProperty('guarded');
    $property->setAccessible(true);
    expect($property->getValue($module))->toBe([]);
});

it('has casts property for is_activable', function () {
    $module = new Module();
    $casts = $module->getCasts();
    expect($casts)->toHaveKey('is_activable');
    expect($casts['is_activable'])->toBe('boolean');
});

it('has casts property for active', function () {
    $module = new Module();
    $casts = $module->getCasts();
    expect($casts)->toHaveKey('active');
    expect($casts['active'])->toBe('boolean');
});

it('can be instantiated', function () {
    $module = new Module();
    expect($module)->toBeInstanceOf(Module::class);
});
