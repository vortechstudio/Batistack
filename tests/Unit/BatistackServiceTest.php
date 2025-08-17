<?php

use App\Services\Batistack;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;

test('get method returns a successful response', function () {
    Http::fake([
        '*/api/health' => Http::response([], 200),
    ]);

    $batistack = new Batistack();
    $response = $batistack->get('/api/health');

    expect($response)->toBeInstanceOf(Response::class);
    expect($response->successful())->toBeTrue();
});

test('get method returns a 500 response on exception', function () {
    Http::fake([
        '*/api/health' => function () {
            throw new \Exception('API request failed');
        },
    ]);

    $batistack = new Batistack();
    $response = $batistack->get('/api/health');

    expect($response)->toBeInstanceOf(Response::class);
    expect($response->status())->toBe(500);
});

test('post method returns a successful response', function () {
    Http::fake([
        '*/api/data' => Http::response([], 201),
    ]);

    $batistack = new Batistack();
    $response = $batistack->post('/api/data', ['key' => 'value']);

    expect($response)->toBeInstanceOf(Response::class);
    expect($response->successful())->toBeTrue();
});

test('post method returns a 500 response on exception', function () {
    Http::fake([
        '*/api/data' => function () {
            throw new \Exception('API request failed');
        },
    ]);

    $batistack = new Batistack();
    $response = $batistack->post('/api/data', ['key' => 'value']);

    expect($response)->toBeInstanceOf(Response::class);
    expect($response->status())->toBe(500);
});

test('put method returns a successful response', function () {
    Http::fake([
        '*/api/data/1' => Http::response([], 200),
    ]);

    $batistack = new Batistack();
    $response = $batistack->put('/api/data/1', ['key' => 'new_value']);

    expect($response)->toBeInstanceOf(Response::class);
    expect($response->successful())->toBeTrue();
});

test('put method returns a 500 response on exception', function () {
    Http::fake([
        '*/api/data/1' => function () {
            throw new \Exception('API request failed');
        },
    ]);

    $batistack = new Batistack();
    $response = $batistack->put('/api/data/1', ['key' => 'new_value']);

    expect($response)->toBeInstanceOf(Response::class);
    expect($response->status())->toBe(500);
});

test('delete method returns a successful response', function () {
    Http::fake([
        '*/api/data/1' => Http::response([], 204),
    ]);

    $batistack = new Batistack();
    $response = $batistack->delete('/api/data/1');

    expect($response)->toBeInstanceOf(Response::class);
    expect($response->successful())->toBeTrue();
});

test('delete method returns a 500 response on exception', function () {
    Http::fake([
        '*/api/data/1' => function () {
            throw new \Exception('API request failed');
        },
    ]);

    $batistack = new Batistack();
    $response = $batistack->delete('/api/data/1');

    expect($response)->toBeInstanceOf(Response::class);
    expect($response->status())->toBe(500);
});
