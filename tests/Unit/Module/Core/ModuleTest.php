<?php

use App\Models\Module\Core\Module;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('uses the HasFactory trait', function () {
    $reflection = new ReflectionClass(Module::class);
    $traits = $reflection->getTraitNames();
    expect($traits)->toContain(HasFactory::class);
});

it('has guarded property set to empty array', function () {
    $module = new Module();
    expect($module->getGuarded())->toBe([]);
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

it('can be created using factory', function () {
    $module = Module::factory()->make();
    expect($module)->toBeInstanceOf(Module::class);
    expect($module->name)->not->toBeNull();
    expect($module->slug)->not->toBeNull();
});
