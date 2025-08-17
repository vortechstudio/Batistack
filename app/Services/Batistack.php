<?php

namespace App\Services;

use Exception;
use Http;
use Illuminate\Support\Facades\Log;

class Batistack
{
    public string $endpoint;

    public function __construct()
    {
        $this->endpoint = config('core.saas_api_endpoint');
    }

    public function get(string $path, ?array $data = [])
    {
        $url = $this->endpoint . $path;

        try {
            $response = Http::withoutVerifying()
                ->get($url, $data);

            return $response;
        } catch (Exception $e) {
            Log::error('API GET error: ' . $e->getMessage());
            return new \Illuminate\Http\Client\Response(new \GuzzleHttp\Psr7\Response(500), [], null);
        }
    }

    public function post(string $path, ?array $data = [])
    {
        $url = $this->endpoint . $path;

        try {
            $response = Http::withoutVerifying()
                ->post($url, $data);

            return $response;
        } catch (Exception $e) {
            Log::error('API POST error: ' . $e->getMessage());
            return new \Illuminate\Http\Client\Response(new \GuzzleHttp\Psr7\Response(500), [], null);
        }
    }

    public function put(string $path, ?array $data = [])
    {
        $url = $this->endpoint . $path;

        try {
            $response = Http::withoutVerifying()
                ->put($url, $data);

            return $response;
        } catch (Exception $e) {
            Log::error('API PUT error: ' . $e->getMessage());
            return new \Illuminate\Http\Client\Response(new \GuzzleHttp\Psr7\Response(500), [], null);
        }
    }

    public function delete(string $path, ?array $data = [])
    {
        $url = $this->endpoint . $path;

        try {
            $response = Http::withoutVerifying()
                ->delete($url, $data);

            return $response;
        } catch (Exception $e) {
            Log::error('API DELETE error: ' . $e->getMessage());
            return new \Illuminate\Http\Client\Response(new \GuzzleHttp\Psr7\Response(500), [], null);
        }
    }
}
