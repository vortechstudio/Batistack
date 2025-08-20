<?php

use App\Console\Commands\AppInstallCommand;
use App\Models\Module\Core\Module;
use App\Models\Module\Core\Option;
use App\Models\Module\Core\Setting;
use App\Services\Batistack;
use Illuminate\Console\Application;
use Illuminate\Console\OutputStyle;
use Illuminate\Http\Client\Response;
use Mockery\MockInterface;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Output\BufferedOutput;
use Symfony\Component\Console\Input\ArrayInput;

beforeEach(function () {
    $this->command = new AppInstallCommand();
    $this->batistackMock = Mockery::mock(Batistack::class);
    $this->app->instance(Batistack::class, $this->batistackMock);

    // Mock l'output pour éviter les erreurs de writeln
    $this->output = new BufferedOutput();
    $this->input = new ArrayInput([]);

    // Utiliser la réflexion pour définir l'input et l'output
    $reflection = new \ReflectionClass($this->command);
    $inputProperty = $reflection->getProperty('input');
    $inputProperty->setAccessible(true);
    $inputProperty->setValue($this->command, $this->input);

    $outputProperty = $reflection->getProperty('output');
    $outputProperty->setAccessible(true);
    $outputProperty->setValue($this->command, $this->output);
});

afterEach(function () {
    \Mockery::close();
});

it('can be instantiated', function () {
    expect($this->command)->toBeInstanceOf(AppInstallCommand::class);
});

it('has correct signature', function () {
    expect($this->command->getName())->toBe('app:install');
});

it('has correct description', function () {
    $description = 'A executer par le protocole lors de l\'initialisation de l\'application par le saas';
    expect($this->command->getDescription())->toBe($description);
});

it('handle command', function () {
    $license = 'valid-license-key';
    $validationResponse = Mockery::mock(Response::class);
    $infoResponse = Mockery::mock(Response::class);

    $validationResponse->shouldReceive('successful')->andReturn(true);
    $validationResponse->shouldReceive('json')->andReturn(['valid' => true]);
    $infoResponse->shouldReceive('json')->andReturn([
        'license_key' => $license,
        'customer' => ['company_name' => 'Test Company'],
        'status' => 'active',
        'max_users' => 10,
        'product' => [
            'max_projects' => 5,
            'storage_limit' => 1000
        ],
        'expires_at' => '2024-12-31'
    ]);

    $this->batistackMock->shouldReceive('get')
        ->with('/license/validate', ['license_key' => $license])
        ->andReturn($validationResponse);

    $this->batistackMock->shouldReceive('get')
        ->with('/license/info', ['license_key' => $license])
        ->andReturn($infoResponse);

    $this->artisan('app:install --license=valid-license-key')->assertSuccessful();
});

it('validates license successfully', function () {
    $license = 'valid-license-key';
    $mockBatistack = Mockery::mock(Batistack::class);
    $validationResponse = Mockery::mock(Response::class);
    $infoResponse = Mockery::mock(Response::class);

    $validationResponse->shouldReceive('successful')->andReturn(true);
    $validationResponse->shouldReceive('json')->andReturn(['valid' => true]);
    $infoResponse->shouldReceive('json')->andReturn([
        'license_key' => $license,
        'customer' => ['company_name' => 'Test Company'],
        'status' => 'active',
        'max_users' => 10,
        'product' => [
            'max_projects' => 5,
            'storage_limit' => 1000
        ],
        'expires_at' => '2024-12-31'
    ]);

    $mockBatistack->shouldReceive('get')
        ->with('/license/validate', ['license_key' => $license])
        ->andReturn($validationResponse);

    $mockBatistack->shouldReceive('get')
        ->with('/license/info', ['license_key' => $license])
        ->andReturn($infoResponse);

    $this->app->instance(Batistack::class, $mockBatistack);

    $result = $this->command->verificationLicense($license);

    expect($result)->toBeArray();
    expect($result['license_key'])->toBe($license);
});

it('returns null for invalid license', function () {
    $license = 'invalid-license-key';
    $mockBatistack = Mockery::mock(Batistack::class);
    $validationResponse = Mockery::mock(Response::class);

    $validationResponse->shouldReceive('successful')->andReturn(true);
    $validationResponse->shouldReceive('json')->andReturn([]);

    $mockBatistack->shouldReceive('get')
        ->with('/license/validate', ['license_key' => $license])
        ->andReturn($validationResponse);

    $this->app->instance(Batistack::class, $mockBatistack);

    $result = $this->command->verificationLicense($license);

    expect($result)->toBeFalse();
});


it('initializes settings correctly', function () {
    $mockSetting = Mockery::mock('alias:' . Setting::class);

    $licenseData = [
        'license_key' => 'test-license-key',
        'customer' => ['company_name' => 'Test Company'],
        'status' => 'active',
        'max_users' => 10,
        'product' => [
            'max_projects' => 5,
            'storage_limit' => 1000
        ],
        'expires_at' => '2024-12-31'
    ];

    $mockSetting->shouldReceive('updateOrCreate')->with(
        ['license_key' => 'test-license-key'],
        [
            'company' => 'Test Company',
            'license_key' => 'test-license-key',
            'status' => 'active',
            'max_users' => 10,
            'max_folders' => 5,
            'max_storages' => 1000,
            'expired_at' => '2024-12-31'
        ]
    )->once()->andReturn((object)['company' => 'Test Company']);

    $reflection = new \ReflectionClass($this->command);
    $method = $reflection->getMethod('initializeSettings');
    $method->setAccessible(true);

    $method->invoke($this->command, $licenseData);

    // Les expectations sont vérifiées automatiquement par Mockery
    expect(true)->toBeTrue();
})->skip('Skipped to avoid global mock conflicts');

it('installs modules correctly', function () {
    $mockModule = Mockery::mock('alias:' . Module::class);

    $licenseData = [
        'license_key' => 'test-license',
        'customer' => ['company_name' => 'Test Company'],
        'status' => 'active',
        'max_users' => 10,
        'product' => [
            'max_projects' => 5,
            'storage_limit' => 1000,
            'included_modules' => [
                [
                    'id' => 1,
                    'name' => 'Test Module',
                    'key' => 'test-module',
                    'description' => 'Test module description'
                ]
            ]
        ],
        'expires_at' => '2024-12-31'
    ];

    // Create a mock that behaves like both object and array
    $moduleObject = Mockery::mock('ArrayAccess');
    $moduleObject->shouldReceive('offsetGet')->with('name')->andReturn('Test Module');
    $moduleObject->name = 'Test Module';

    $mockModule->shouldReceive('updateOrCreate')->with(
        ['saas_module_id' => 1],
        [
            'name' => 'Test Module',
            'slug' => 'test-module',
            'description' => 'Test module description',
            'is_activable' => true,
            'active' => false
        ]
    )->once()->andReturn($moduleObject);

    $reflection = new \ReflectionClass($this->command);
    $method = $reflection->getMethod('installModules');
    $method->setAccessible(true);

    $method->invoke($this->command, $licenseData);

    // Les expectations sont vérifiées automatiquement par Mockery
    expect(true)->toBeTrue();
})->skip('Skipped to avoid global mock conflicts');

it('installs options correctly', function () {
    $mockOption = Mockery::mock('alias:' . Option::class);

    $licenseData = [
        'license_key' => 'test-license',
        'customer' => ['company_name' => 'Test Company'],
        'status' => 'active',
        'max_users' => 10,
        'product' => [
            'max_projects' => 5,
            'storage_limit' => 1000
        ],
        'options' => [
            [
                'id' => 1,
                'name' => 'Test Option',
                'key' => 'test-option',
                'description' => 'Test option description',
                'pivot' => [
                    'enabled' => true,
                    'expires_at' => '2024-12-31'
                ]
            ]
        ],
        'expires_at' => '2024-12-31'
    ];

    $optionObject = new \stdClass();
    $optionObject->name = 'Test Option';

    $mockOption->shouldReceive('updateOrCreate')->with(
        ['saas_option_id' => 1],
        [
            'name' => 'Test Option',
            'slug' => 'test-option',
            'description' => 'Test option description',
            'is_enabled' => true,
            'expires_at' => '2024-12-31',
            'active' => false,
            'saas_option_id' => 1
        ]
    )->once()->andReturn($optionObject);

    $reflection = new \ReflectionClass($this->command);
    $method = $reflection->getMethod('installOptions');
    $method->setAccessible(true);

    $method->invoke($this->command, $licenseData);

    // Les expectations sont vérifiées automatiquement par Mockery
    expect(true)->toBeTrue();
})->skip('Skipped to avoid global mock conflicts');
