<?php

namespace Database\Seeders;

use App\Models\Core\Company;
use App\Models\Core\PlanComptable;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'role' => 'admin',
        ]);

        $cpt = Company::create();
        $cpt->info()->create();

        $this->installPCG();
    }

    private function installPCG()
    {
        $items = \Http::withoutVerifying()->get('https://raw.githubusercontent.com/arrhes/PCG/refs/heads/main/versions/2024.json')->json();
        foreach ($items as $item) {
            $pcg = PlanComptable::create([
                "compte" => $item['number'],
                "libelle" => $item['label'],
                "groupe" => null,
            ]);

            if(count($item['accounts']) != 0) {
                foreach ($item['accounts'] as $account) {
                    $subpcg = PlanComptable::create([
                        "compte" => $account['number'],
                        "libelle" => $account['label'],
                        "groupe" => null,
                        "parent_id" => $pcg->id,
                    ]);

                    if(count($account['accounts']) != 0) {
                        foreach ($account['accounts'] as $subaccount) {
                            $sub2 = PlanComptable::create([
                                "compte" => $subaccount['number'],
                                "libelle" => $subaccount['label'],
                                "groupe" => null,
                                "parent_id" => $subpcg->id,
                            ]);

                            if(count($subaccount['accounts']) != 0) {
                                foreach ($subaccount['accounts'] as $i) {
                                    $sub3 = PlanComptable::create([
                                        "compte" => $i['number'],
                                        "libelle" => $i['label'],
                                        "groupe" => null,
                                        "parent_id" => $sub2->id,
                                    ]);

                                    if(count($i['accounts']) != 0) {
                                        foreach ($i['accounts'] as $o) {
                                            $sub4 = PlanComptable::create([
                                                "compte" => $o['number'],
                                                "libelle" => $o['label'],
                                                "groupe" => null,
                                                "parent_id" => $sub3->id,
                                            ]);

                                            if(count($o['accounts']) != 0) {
                                                foreach ($o['accounts'] as $u) {
                                                    PlanComptable::create([
                                                        "compte" => $u['number'],
                                                        "libelle" => $u['label'],
                                                        "groupe" => null,
                                                        "parent_id" => $sub4->id,
                                                    ]);
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }

    }
}
