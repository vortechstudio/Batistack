<?php

namespace App\Console\Commands;

use App\Models\Core\City;
use App\Models\Core\Country;
use App\Models\Core\PlanComptable;
use Illuminate\Console\Command;

class InstallProviderCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install Test Command Provider';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->call('migrate:fresh', ['--seed' =>  true]);
        $this->installCPG();
        $this->newLine(1);
        $this->installCountries();
    }

    private function installCPG(): void
    {
        $this->info("Installation du plan comptable général");
        $items = \Http::withoutVerifying()->get('https://raw.githubusercontent.com/arrhes/PCG/refs/heads/main/versions/2024.json')->json();
        $count = count($items);
        $bar = $this->output->createProgressBar($count);
        $bar->start();
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
            $bar->advance();
        }
        $bar->finish();
    }

    private function installCountries()
    {
        $this->info("Installation des informations des pays");

        $countries = \Http::withoutVerifying()
            ->get('https://gist.githubusercontent.com/revolunet/6173043/raw/222c4537affb1bdecbabcec51143742709aa0b6e/countries-FR.json')
            ->json();

        $bar = $this->output->createProgressBar(count($countries));
        $bar->start();

        foreach ($countries as $k => $country) {
            Country::create([
                'name' => $country
            ]);
            $bar->advance();
        }
        $bar->finish();
    }
}
