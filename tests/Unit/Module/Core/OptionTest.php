<?php

use App\Models\Module\Core\Option;
use Illuminate\Database\Eloquent\Factories\HasFactory;

it('uses the HasFactory trait', function () {
    $uses = class_uses_recursive(Option::class);
    expect($uses)->toContain(HasFactory::class);
});

it('has guarded property set to empty array', function () {
    $option = new Option();
    $reflection = new ReflectionClass($option);
    $property = $reflection->getProperty('guarded');
    $property->setAccessible(true);
    expect($property->getValue($option))->toBe([]);
});

it('has casts property for is_enabled', function () {
    $option = new Option();
    $casts = $option->getCasts();
    expect($casts)->toHaveKey('is_enabled');
    expect($casts['is_enabled'])->toBe('boolean');
});

it('has casts property for expires_at', function () {
    $option = new Option();
    $casts = $option->getCasts();
    expect($casts)->toHaveKey('expires_at');
    expect($casts['expires_at'])->toBe('date');
});

it('has casts property for active', function () {
    $option = new Option();
    $casts = $option->getCasts();
    expect($casts)->toHaveKey('active');
    expect($casts['active'])->toBe('boolean');
});

it('can be instantiated', function () {
    $option = new Option();
    expect($option)->toBeInstanceOf(Option::class);
});
