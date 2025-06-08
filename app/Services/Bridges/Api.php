<?php

namespace App\Services\Bridges;

class Api
{
    private string $client_id;
    private string $client_secret;

    public function __construct()
    {
        $this->client_id = config('bridge.bridge_client_id');
        $this->client_secret = config('bridge.bridge_client_secret');
    }

    public function get(string $folder, array|null $data = null, string $withToken = null): ?array
    {
        try {
            if($withToken) {
                $request = \Http::withoutVerifying()->withHeaders([
                    'Bridge-Version' => config('bridge.bridge_api_version'),
                    'Client-Id' => $this->client_id,
                    'Client-Secret' => $this->client_secret,
                    'accept' => 'application/json',
                    'content-type' => 'application/json',
                    'authorization' => 'Bearer '.$withToken,
                ])
                    ->get(config('bridge.bridge_api_endpoint').$folder, $data)
                    ->json();
            } else {
                $request = \Http::withoutVerifying()->withHeaders([
                    'Bridge-Version' => config('bridge.bridge_api_version'),
                    'Client-Id' => $this->client_id,
                    'Client-Secret' => $this->client_secret,
                    'accept' => 'application/json',
                    'content-type' => 'application/json',
                ])
                    ->get(config('bridge.bridge_api_endpoint').$folder, $data)
                    ->json();
            }

            return collect($request)->toArray();
        }catch (\Exception $exception) {
            \Log::emergency($exception);
            toastr()->addError($exception->getMessage());
            return null;
        }
    }

    public function post(string $folder, array|null $data = null, string|null $withToken = null): ?array
    {
        try {
            if ($withToken) {
                $request = \Http::withoutVerifying()->withHeaders([
                    'Bridge-Version' => config('bridge.bridge_api_version'),
                    'Client-Id' => $this->client_id,
                    'Client-Secret' => $this->client_secret,
                    'accept' => 'application/json',
                    'authorization' => 'Bearer '.$withToken,
                    'content-type' => 'application/json',
                ])
                    ->post(config('bridge.bridge_api_endpoint').$folder, $data)
                    ->json();
            } else {
                $request = \Http::withoutVerifying()->withHeaders([
                    'Bridge-Version' => config('bridge.bridge_api_version'),
                    'Client-Id' => $this->client_id,
                    'Client-Secret' => $this->client_secret,
                    'accept' => 'application/json',
                    'content-type' => 'application/json',
                ])
                    ->post(config('bridge.bridge_api_endpoint').$folder, $data)
                    ->json();
            }

            return collect($request)->toArray();
        }catch (\Exception $exception) {
            \Log::emergency($exception);
            toastr()->addError($exception->getMessage());
            return null;
        }
    }

    public function put(string $folder, array|null $data = null): ?array
    {
        try {
            $request = \Http::withoutVerifying()->withHeaders([
                'Bridge-Version' => config('bridge.bridge_api_version'),
                'Client-Id' => $this->client_id,
                'Client-Secret' => $this->client_secret,
                'accept' => 'application/json',
                'content-type' => 'application/json',
                'authorization' => 'Bearer '.cache('bridge_access_token'),
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

    public function delete(string $folder, array|null $data = null): ?array
    {
        try {
            $request = \Http::withoutVerifying()->withHeaders([
                'Bridge-Version' => config('bridge.bridge_api_version'),
                'Client-Id' => $this->client_id,
                'Client-Secret' => $this->client_secret,
                'accept' => 'application/json',
                'content-type' => 'application/json',
                'authorization' => 'Bearer '.cache('bridge_access_token'),
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

    public static function getProvidersToSelect()
    {
        $api = new Api();
        $resources = collect($api->get('providers?limit=500&country_code=FR')['resources'])
            ->mapWithKeys(function ($resource) {
                return [
                    $resource['name'] => "<div class='d-flex flex-row align-items-center'><img alt src='".$resource['images']['logo']."' class='img-thumbnail w-30px' /> ".$resource['name']."</div>"
                ];
            })->toArray();

        return $resources;
    }

}
