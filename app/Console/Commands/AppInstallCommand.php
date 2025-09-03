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
        $maxUsers   = (int) data_get(
            $license,
            'product.info_stripe.metadata.max_users',
            data_get($license, 'max_users', 0)
        );
        $maxStorage = (int) data_get(
            $license,
            'product.info_stripe.metadata.storage_limit',
            data_get($license, 'product.storage_limit', 0)
        );

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

        // Backward-compatible license key extraction
        $licenseKey = $license['service_code'] ?? $license['license_key'] ?? null;

        // Safe nested key access with fallbacks
        $company = isset($license['customer']['entreprise'])
            ? $license['customer']['entreprise']
            : (isset($license['customer']['company_name'])
                ? $license['customer']['company_name']
                : ($license['company'] ?? null));

        $maxUsers = isset($license['product']['info_stripe']['metadata']['max_users'])
            ? $license['product']['info_stripe']['metadata']['max_users']
            : ($license['max_users'] ?? 0);

        $maxFolders = isset($license['product']['max_projects'])
            ? $license['product']['max_projects']
            : ($license['max_folders'] ?? 1);

        $maxStorages = isset($license['product']['info_stripe']['metadata']['storage_limit'])
            ? $license['product']['info_stripe']['metadata']['storage_limit']
            : ($license['max_storages'] ?? 0);

        $expiredAt = $license['expirationDate'] ?? $license['expired_at'] ?? null;

        $config = Setting::updateOrCreate(
            ["license_key" => $licenseKey],
            [
                "company"      => $company,
                "license_key"  => $licenseKey,
                "status"       => $license['status'] ?? null,
                "max_users"    => $maxUsers,
                "max_folders"  => $maxFolders,
                "max_storages" => $maxStorages,
                "expired_at"   => $expiredAt,
            ]
        );
        $this->info("Paramètres de la license initialisés");
        $this->info("Entreprise: " . $config->company);
    }

    public function installModules($license)
    {
        $this->line("Initialisation des modules saas");
        // Add fallback to included_modules for backward compatibility
        $moduleSaas = $license['product']['features'] ?? $license['included_modules'] ?? [];
        if (empty($moduleSaas)) {
            $this->info("Aucun module à installer");
            return;
        }
        foreach ($moduleSaas as $moduleData) {
            $this->line("Installation du module " . $moduleData['name']);

            // Add fallback for slug field (use 'key' if 'slug' is missing)
            $slug = $moduleData['slug'] ?? $moduleData['key'] ?? null;

            // Validate that we have a valid slug
            if (empty($slug)) {
                $this->error("Error: Module '" . ($moduleData['name'] ?? 'Unknown') . "' has no slug or key identifier");
                continue;
            }

            // Normalize slug (trim whitespace)
            $slug = trim($slug);

            $createdModule = Module::updateOrCreate(
                ['saas_module_id' => $moduleData['id']],
                [
                    "name" => $moduleData['name'],
                    "slug" => $slug,
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
