<?php

namespace App\Console\Commands;

use App\Models\Core\City;
use App\Models\Core\ConditionReglement;
use App\Models\Core\Country;
use App\Models\Core\ModeReglement;
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
        $this->newLine(1);
        $this->installConditionReglement();
        $this->newLine(1);
        $this->installModeReglement();
        $this->newLine(1);
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

    private function installConditionReglement()
    {
        $this->info("Installation des conditions de reglements");
        $bar = $this->output->createProgressBar(10);
        ConditionReglement::create([
            "code" => "RECEP",
            "libelle" => "A Réception",
            "libelle_document" => "A réception",
            "nb_jours" => 1,
            "fin_de_mois" => 0
        ]);
        $bar->advance();

        ConditionReglement::create([
            "code" => "30D",
            "libelle" => "30 Jours",
            "libelle_document" => "Réglement à 30 jours",
            "nb_jours" => 30,
            "fin_de_mois" => 0
        ]);
        $bar->advance();

        ConditionReglement::create([
            "code" => "30DM",
            "libelle" => "30 Jours fin de mois",
            "libelle_document" => "Réglement à 30 jours fin de mois",
            "nb_jours" => 30,
            "fin_de_mois" => 1
        ]);
        $bar->advance();

        ConditionReglement::create([
            "code" => "60D",
            "libelle" => "60 Jours",
            "libelle_document" => "Réglement à 60 jours",
            "nb_jours" => 60,
            "fin_de_mois" => 0
        ]);
        $bar->advance();

        ConditionReglement::create([
            "code" => "60DM",
            "libelle" => "60 Jours fin de mois",
            "libelle_document" => "Réglement à 60 jours fin de mois",
            "nb_jours" => 60,
            "fin_de_mois" => 1
        ]);
        $bar->advance();

        ConditionReglement::create([
            "code" => "PT_ORDER",
            "libelle" => "A Commande",
            "libelle_document" => "A réception de la commande",
            "nb_jours" => 1,
            "fin_de_mois" => 0
        ]);
        $bar->advance();

        ConditionReglement::create([
            "code" => "PT_DELIVERY",
            "libelle" => "A livraison",
            "libelle_document" => "Règlement à la livraison",
            "nb_jours" => 1,
            "fin_de_mois" => 0
        ]);
        $bar->advance();

        ConditionReglement::create([
            "code" => "PT_5050",
            "libelle" => "50/50",
            "libelle_document" => "50% acompte commande / 50% à la livraison",
            "nb_jours" => 1,
            "fin_de_mois" => 0
        ]);
        $bar->advance();

        ConditionReglement::create([
            "code" => "14D",
            "libelle" => "14 Jours",
            "libelle_document" => "14 Jours",
            "nb_jours" => 14,
            "fin_de_mois" => 0
        ]);
        $bar->advance();

        ConditionReglement::create([
            "code" => "14DM",
            "libelle" => "14 Jours fin de mois",
            "libelle_document" => "Sous 14 jours suivant la fin du mois",
            "nb_jours" => 14,
            "fin_de_mois" => 1
        ]);
        $bar->finish();
    }

    private function installModeReglement()
    {
        $this->info("Installation des modes de reglements");
        $bar = $this->output->createProgressBar(8);
        $bar->start();
        ModeReglement::create(["code" => "CB", "libelle" => "Carte Bancaire"]); $bar->advance();
        ModeReglement::create(["code" => "CHQ", "libelle" => "Chèque"]);  $bar->advance();
        ModeReglement::create(["code" => "LCR", "libelle" => "LCR"]);  $bar->advance();
        ModeReglement::create(["code" => "PPL", "libelle" => "Paypal"]);   $bar->advance();
        ModeReglement::create(["code" => "PRE", "libelle" => "Prélèvement Bancaire"]); $bar->advance();
        ModeReglement::create(["code" => "TIP", "libelle" => "TIP (Titre Interbancaire de paiement)"]);  $bar->advance();
        ModeReglement::create(["code" => "TRA", "libelle" => "Traite"]);   $bar->advance();
        ModeReglement::create(["code" => "VIR", "libelle" => "Virement Bancaire"]);  $bar->advance();
        $bar->finish();
    }
}
