<?php

namespace App\Http\Middleware;

use App\Services\Batistack;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ApiCheckMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        // Skip API check in testing environment
        if (app()->environment('testing')) {
            return $next($request);
        }

        $batistack = new Batistack();
        // Faire l'appel API
        $response = $batistack->get('/health');

        // Vérifier le statut de la réponse
        if (!$response->successful()) {
            return response()->view('errors.500', [
                'message' => 'Erreur de connexion à l\'API: L\'API n\'a pas répondu comme prévu.'
            ], 500);
        }

        return $next($request);
    }
}
