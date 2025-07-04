<?php

namespace App\Services;

use Illuminate\Http\Client\ConnectionException;

class Siren
{

    /**
     * @param string $siren
     * @param string $type
     * @return bool|array|null
     * @throws ConnectionException
     */
    public function call(string $siren, string $type = 'info'): bool|array|null
    {
        $request = \Http::withoutVerifying()
            ->withHeaders([
                "X-INSEE-Api-Key-Integration" => config('services.siren_api.key')
            ])
            ->get('https://api.insee.fr/api-sirene/3.11/siren/'.$siren);

        if($request->getStatusCode() === 404) {
            return false;
        } else {
            if($type === 'info') {
                return $request->json()['uniteLegale'];
            } else {
                return true;
            }
        }
    }
}
