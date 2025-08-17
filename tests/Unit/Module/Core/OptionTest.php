<?php

use App\Models\Module\Core\Option;
use Illuminate\Database\Eloquent\Factories\HasFactory;

it('uses the HasFactory trait', function () {
    $uses = class_uses(Option::class);
    expect($uses)->toContain(HasFactory::class);
});

it('has guarded property set to empty array', function () {
    $option = new Option();
    expect($option->getGuarded())->toBe([]);
});

it('has casts property for is_enabled', function () {
    $option = new Option();
    expect($option->getCasts())->toHaveKey('is_enabled');
    expect($option->getCasts()['is_enabled'])->toBe('boolean');
});

it('has casts property for expires_at', function () {
    $option = new Option();
    expect($option->getCasts())->toHaveKey('expires_at');
    expect($option->getCasts()['expires_at'])->toBe('date');
});

it('has casts property for active', function () {
    $option = new Option();
    expect($option->getCasts())->toHaveKey('active');
    expect($option->getCasts()['active'])->toBe('boolean');
});

it('can be instantiated', function () {
    $option = new Option();
    expect($option)->toBeInstanceOf(Option::class);
});