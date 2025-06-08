<?php

namespace Database\Seeders;

use App\Models\Core\City;
use App\Models\Core\Company;
use App\Models\Core\Country;
use App\Models\Core\PlanComptable;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Services\Bridges\Api;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();
        //$this->deleteAllBridge();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'role' => 'admin',
        ]);

        $cpt = Company::create();
        $cpt->info()->create();

        $this->installCities();
    }

    private function installCities()
    {
        $cities = \Http::withoutVerifying()
            ->get('https://raw.githubusercontent.com/high54/Communes-France-JSON/refs/heads/master/france.json')
            ->json();

        foreach ($cities as $city) {
            $latLong = explode(',', $city['coordonnees_gps']);

            City::create([
                'city' =>  $city['Nom_commune'],
                'postal_code' =>  $city['Code_postal'],
                'latitude' =>  $latLong[0] ?? null,
                'longitude' =>  $latLong[1] ?? null,
            ]);
        }
    }
}
