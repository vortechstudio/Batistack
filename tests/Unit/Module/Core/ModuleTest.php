<?php

use App\Models\Module\Core\Module;
use Illuminate\Database\Eloquent\Factories\HasFactory;

it('uses the HasFactory trait', function () {
    $uses = class_uses(Module::class);
    expect($uses)->toContain(HasFactory::class);
});

it('has guarded property set to empty array', function () {
    $module = new Module();
    expect($module->getGuarded())->toBe([]);
});

it('has casts property for is_activable', function () {
    $module = new Module();
    expect($module->getCasts())->toHaveKey('is_activable');
    expect($module->getCasts()['is_activable'])->toBe('boolean');
});

it('has casts property for active', function () {
    $module = new Module();
    expect($module->getCasts())->toHaveKey('active');
    expect($module->getCasts()['active'])->toBe('boolean');
});

it('can be instantiated', function () {
    $module = new Module();
    expect($module)->toBeInstanceOf(Module::class);
});