<?php

namespace App\Services\Bridges;

class Api
{
    public function __construct(
        private string $client_id,
        private string $client_secret,
    )
    {
        $this->client_id = config('bridge.bridge_client_id');
        $this->client_secret = config('bridge.bridge_client_secret');
    }

    public function get(string $folder, array $data): ?array
    {
        try {
            $request = \Http::withHeaders([
                'Bridge-Version' => config('bridge.bridge_api_version'),
                'Client-Id' => $this->client_id,
                'Client-Secret' => $this->client_secret,
                'accept' => 'application/json',
                'content-type' => 'application/json',
            ])
                ->get(config('bridge.bridge_api_endpoint').$folder, $data)
                ->json();

            return collect($request)->toArray();
        }catch (\Exception $exception) {
            \Log::emergency($exception);
            toastr()->addError($exception->getMessage());
            return null;
        }
    }

    public function post(string $folder, array $data): ?array
    {
        try {
            $request = \Http::withHeaders([
                'Bridge-Version' => config('bridge.bridge_api_version'),
                'Client-Id' => $this->client_id,
                'Client-Secret' => $this->client_secret,
                'accept' => 'application/json',
                'content-type' => 'application/json',
            ])
                ->post(config('bridge.bridge_api_endpoint').$folder, $data)
                ->json();

            return collect($request)->toArray();
        }catch (\Exception $exception) {
            \Log::emergency($exception);
            toastr()->addError($exception->getMessage());
            return null;
        }
    }

    public function put(string $folder, array $data): ?array
    {
        try {
            $request = \Http::withHeaders([
                'Bridge-Version' => config('bridge.bridge_api_version'),
                'Client-Id' => $this->client_id,
                'Client-Secret' => $this->client_secret,
                'accept' => 'application/json',
                'content-type' => 'application/json',
            ])
                ->put(config('bridge.bridge_api_endpoint').$folder, $data)
                ->json();

            return collect($request)->toArray();
        }catch (\Exception $exception) {
            \Log::emergency($exception);
            toastr()->addError($exception->getMessage());
            return null;
        }
    }

    public function delete(string $folder, array $data): ?array
    {
        try {
            $request = \Http::withHeaders([
                'Bridge-Version' => config('bridge.bridge_api_version'),
                'Client-Id' => $this->client_id,
                'Client-Secret' => $this->client_secret,
                'accept' => 'application/json',
                'content-type' => 'application/json',
            ])
                ->delete(config('bridge.bridge_api_endpoint').$folder, $data)
                ->json();

            return collect($request)->toArray();
        }catch (\Exception $exception) {
            \Log::emergency($exception);
            toastr()->addError($exception->getMessage());
            return null;
        }
    }

}
