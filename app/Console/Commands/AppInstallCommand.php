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

        if (empty($license)) {
            $this->error('License parameter is required. Use --license=your_license_key');
            return Command::FAILURE;
        }

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
        $response = app(Batistack::class)
            ->get('/license/validate', ['license_key' => $license]);

        if (!$response->successful()) {
            $this->error('Erreur lors de la validation de la licence');
            return false;
        }

        $validationData = $response->json();

        if (empty($validationData) || !isset($validationData['valid']) || $validationData['valid'] !== true) {
            $this->error('Licence invalide ou données de validation manquantes');
            return false;
        }

        $this->info("Status de la license: License Valide");
        return app(Batistack::class)
            ->get('/license/info', ['license_key' => $license])
            ->json();
    }

    public function verificationParametre($license)
    {
        //dd($license);
        if (!is_array($license)) {
            $this->error("Invalid license data provided to verificationParametre.");
            return;
        }

        $productName = $license['product']['name'] ?? 'unknown product';
        $domain = $license['domain'] ?? 'unknown domain';
        $maxUsers = $license['product']['info_stripe']['metadata']['max_users'] ?? 0;
        $maxStorage = $license['product']['info_stripe']['metadata']['storage_limit'] ?? 0;

        $this->info("Produit: " . $productName);
        $this->info("Parametre de la license: License attribué à " . $domain);
        $this->info("Parametre de la license: License Max Users " . $maxUsers);
        $this->info("Parametre de la license: License Limit Storage " . $maxStorage);

        if ($productName === 'unknown product' || $domain === 'unknown domain' || $maxUsers === 0 || $maxStorage === 0) {
            $this->warn("Warning: Some critical license parameters are missing or invalid.");
        }
    }

    public function initializeSettings($license)
    {
        $this->line("Initialisation des paramètres de la license");
        $config = Setting::updateOrCreate(
            ["license_key" => $license['service_code']],
            [
                "company"      => $license['customer']['entreprise']    ?? null,
                "license_key"  => $license['service_code'],
                "status"       => $license['status']                      ?? null,
                "max_users"    => $license['product']['info_stripe']['metadata']['max_users']                   ?? 0,
                "max_folders"  => $license['product']['max_projects']     ?? 1,
                "max_storages" => $license['product']['info_stripe']['metadata']['storage_limit']    ?? 0,
                "expired_at"   => $license['expirationDate']                  ?? null,
            ]
        );
        $this->info("Paramètres de la license initialisés");
        $this->info("Entreprise: " . $config->company);
    }

    public function installModules($license)
    {
        $this->line("Initialisation des modules saas");
        $moduleSaas = $license['product']['features'] ?? [];
        if (empty($moduleSaas)) {
            $this->info("Aucun module à installer");
            return;
        }
        foreach ($moduleSaas as $moduleData) {
            $this->line("Installation du module " . $moduleData['name']);
            $createdModule = Module::updateOrCreate(
                ['saas_module_id' => $moduleData['id']],
                [
                    "name" => $moduleData['name'],
                    "slug" => $moduleData['slug'],
                    "description" => $moduleData['description'],
                    "is_activable" => true,
                    "active" => false,
                ]
            );
            $this->line("Module " . $createdModule->name . " installé");
        }
    }

    public function installOptions($license)
    {
        $this->line("Initialisation des options de la license");
        $options = $license['options'] ?? [];
        $this->line("Nombre d'options: " . count($options));
        if (empty($options)) {
            $this->info("Aucune option à installer");
            return;
        }
        foreach ($options as $option) {
            $this->line("Installation de l'option " . $option['name']);
            Option::updateOrCreate(
                ["saas_option_id" => $option['id']],
                [
                    "name"        => $option['name'],
                    "slug"        => $option['key'],
                    "description" => $option['description'],
                    "is_enabled"  => $option['pivot']['enabled']  ?? false,
                    "expires_at"  => $option['pivot']['expires_at'] ?? null,
                    "active"      => false,
                    "saas_option_id" => $option['id'],
                ]
            );
            $this->line("Option " . $option['name'] . " installée");
        }
    }
}
