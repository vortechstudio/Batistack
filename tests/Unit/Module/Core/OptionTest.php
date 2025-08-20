<?php

use App\Models\Module\Core\Option;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('uses the HasFactory trait', function () {
    $reflection = new ReflectionClass(Option::class);
    $traits = $reflection->getTraitNames();
    expect($traits)->toContain(HasFactory::class);
});

it('has guarded property set to empty array', function () {
    $option = new Option();
    expect($option->getGuarded())->toBe([]);
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

it('can be created using factory', function () {
    $option = Option::factory()->make();
    expect($option)->toBeInstanceOf(Option::class);
    expect($option->name)->not->toBeNull();
    expect($option->slug)->not->toBeNull();
});
