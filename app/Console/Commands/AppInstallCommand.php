<?php

namespace App\Console\Commands;

use App\Models\Module\Core\Module;
use App\Models\Module\Core\Option;
use App\Models\Module\Core\Setting;
use App\Services\Batistack;
use Illuminate\Console\Command;

class AppInstallCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:install {--license=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'A executer par le protocole lors de l\'initialisation de l\'application par le saas';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $license = $this->option('license');


        $infoLicense = $this->verificationLicense($license);
        if($infoLicense) {
            $this->verificationParametre($infoLicense);
            $this->initializeSettings($infoLicense);
            $this->installModules($infoLicense);
            $this->installOptions($infoLicense);
        }
    }

    public function verificationLicense($license)
    {
        $response = app(Batistack::class)->get('/license/validate', ['license_key' => $license]);
        if (!empty($response->json())) {
            $this->info("Status de la license: License Valide");
            return app(Batistack::class)->get('/license/info', ['license_key' => $license])->json();
        } else {
            $this->error("Status de la license: License Invalide");
        }
    }

    public function verificationParametre($license)
    {
        $this->info("Produit: " . $license['product']['name']);
        $this->info("Parametre de la license: License attribué à " . $license['domain']);
        $this->info("Parametre de la license: License Max Users " . $license['max_users']);
        $this->info("Parametre de la license: License Max Folders " . $license['product']['max_projects']);
    }

    public function initializeSettings($license)
    {
        $this->line("Initialisation des paramètres de la license");
        $config = Setting::updateOrCreate(["license_key" => $license['license_key']], [
            "company" => $license['customer']['company_name'],
            "license_key" => $license['license_key'],
            "status" => $license['status'],
            "max_users" => $license['max_users'],
            "max_folders" => $license['product']['max_projects'],
            "max_storages" => $license['product']['storage_limit'],
            "expired_at" => $license['expires_at'],
        ]);
        $this->info("Paramètres de la license initialisés");
        $this->info("Company: " . $config->company);
    }

    public function installModules($license)
    {
        $this->line("Initialisation des modules saas");
        $moduleSaas = $license['product']['included_modules'];

        foreach ($moduleSaas as $module) {
            $this->line("Installation du module " . $module['name']);
            $module = Module::updateOrCreate(
                ['saas_module_id' => $module['id']],
                [
                    "name" => $module['name'],
                    "slug" => $module['key'],
                    "description" => $module['description'],
                    "is_activable" => true,
                    "active" => false,
                ]
            );
            $this->line("Module " . $module['name'] . " installé");
        }
    }

    public function installOptions($license)
    {
        $this->line("Initialisation des options de la license");
        $options = $license['options'];
        $this->line("Nombre d'options: " . count($options));
        foreach ($options as $option) {
            $this->line("Installation de l'option " . $option['name']);
            Option::updateOrCreate(
                ["saas_option_id" => $option['id']],
                [
                    "name" => $option['name'],
                    "slug" => $option['key'],
                    "description" => $option['description'],
                    "is_enabled" => $option['pivot']['enabled'],
                    "expires_at" => $option['pivot']['expires_at'],
                    "active" => false,
                    "saas_option_id" => $option['id'],
                ]
            );
            $this->line("Option " . $option['name'] . " installée");
        }
    }
}
