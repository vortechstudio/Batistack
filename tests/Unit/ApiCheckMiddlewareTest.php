<?php

use App\Http\Middleware\ApiCheckMiddleware;
use App\Services\Batistack;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Http;

test('middleware allows request to continue in testing environment', function () {
    // Simulate testing environment
    app()->detectEnvironment(function () {
        return 'testing';
    });

    $middleware = new ApiCheckMiddleware();
    $request = Request::create('/test', 'GET');
    
    $response = $middleware->handle($request, function ($req) {
        return response('OK', 200);
    });

    expect($response->getStatusCode())->toBe(200);
    expect($response->getContent())->toBe('OK');
});

test('middleware allows request to continue when API is healthy', function () {
    // Mock the environment to not be testing
    app()->detectEnvironment(function () {
        return 'production';
    });

    Http::fake([
        '*/api/health' => Http::response([], 200),
    ]);

    $middleware = new ApiCheckMiddleware();
    $request = Request::create('/test', 'GET');
    
    $response = $middleware->handle($request, function ($req) {
        return response('OK', 200);
    });

    expect($response->getStatusCode())->toBe(200);
    expect($response->getContent())->toBe('OK');
});

test('middleware returns 500 error when API is unhealthy', function () {
    // Mock the environment to not be testing
    app()->detectEnvironment(function () {
        return 'production';
    });

    Http::fake([
        '*/api/health' => Http::response([], 500),
    ]);

    $middleware = new ApiCheckMiddleware();
    $request = Request::create('/test', 'GET');
    
    $response = $middleware->handle($request, function ($req) {
        return response('OK', 200);
    });

    expect($response->getStatusCode())->toBe(500);
});

test('middleware returns 500 error when API throws exception', function () {
    // Mock the environment to not be testing
    app()->detectEnvironment(function () {
        return 'production';
    });

    Http::fake([
        '*/api/health' => function () {
            throw new \Exception('API request failed');
        },
    ]);

    $middleware = new ApiCheckMiddleware();
    $request = Request::create('/test', 'GET');
    
    $response = $middleware->handle($request, function ($req) {
        return response('OK', 200);
    });

    expect($response->getStatusCode())->toBe(500);
});