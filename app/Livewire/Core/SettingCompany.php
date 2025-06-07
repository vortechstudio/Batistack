<?php

namespace App\Livewire\Core;

use App\Models\Core\Company;
use Illuminate\Support\Collection;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithFileUploads;

class SettingCompany extends Component
{
    use WithFileUploads;

    public string $mainmenu = 'core';
    public string $actualmenu = 'core.settings.company';
    public Company $company;

    //FormControl
    public string|null $name = '';
    public string|null $address = '';
    public string|null $cp = '';
    public string|null $city = '';
    public string|null $country = '';
    public string|null $phone = '';
    public string|null $portable = '';
    public string|null $fax = '';
    public string|null $email = '';
    public string|null $web = '';

    public string|null $director = '';
    public string|null $capital = '';
    public string|null $type = '';
    public string|null $object = '';
    public string|null $num_tva = '';
    public string|null $num_siren = '';
    public string|null $num_siret = '';
    public string|null $num_naf = '';
    public string|null $rcs = '';
    public bool $tva = true;
    public array|null|Collection $countries = [];
    public array|Collection|null $typeEntreprise = null;
    public $logo_carre;
    public $logo;


    public function mount()
    {
        $this->company = Company::first()->load('info');

        $this->name = $this->company->name;
        $this->address = $this->company->address;
        $this->cp = $this->company->cp;
        $this->city = $this->company->city;
        $this->country = $this->company->country;
        $this->phone = $this->company->phone;
        $this->portable = $this->company->portable;
        $this->fax = $this->company->fax;
        $this->email = $this->company->email;
        $this->web = $this->company->web;
        $this->countries = $this->updateCountries();

        $this->director = $this->company->info->director;
        $this->capital = $this->company->info->capital;
        $this->type = $this->company->info->type;
        $this->object = $this->company->info->object;
        $this->num_tva = $this->company->info->num_tva;
        $this->num_siren = $this->company->info->num_siren;
        $this->num_siret = $this->company->info->num_siret;
        $this->num_naf = $this->company->info->num_naf;
        $this->rcs = $this->company->info->rcs;
        $this->tva = $this->company->info->tva;
        $this->typeEntreprise = $this->getTypeEnt();
    }

    public function updateCountries()
    {
        $countries = collect();
        $countries1 = \Http::get('https://data.enseignementsup-recherche.gouv.fr/api/explore/v2.1/catalog/datasets/curiexplore-pays/records?limit=100')->json();
        $countries2 = \Http::get('https://data.enseignementsup-recherche.gouv.fr/api/explore/v2.1/catalog/datasets/curiexplore-pays/records?limit=100&offset=101')->json();

        $arr1 = collect($countries1['results'])->filter(function ($country) {
            return isset($country['name_fr']);
        })
            ->pluck('name_fr')
            ->unique()
            ->map(function ($name) {
                return $name;
            })
            ->toArray();
        $arr2 = collect($countries2['results'])->filter(function ($country) {
            return isset($country['name_fr']);
        })
            ->pluck('name_fr')
            ->unique()
            ->map(function ($name) {
                return $name;
            })
            ->toArray();
        $array = array_merge($arr1, $arr2);

        return $countries->push($array)->collapse()->toArray();
    }

    public function getTypeEnt()
    {
        return collect([
            'SARL',
            'SAS',
            'EURL',
        ])->toArray();
    }

    public function saveCompany()
    {
        try {
            Company::first()
                ->update(
                    $this->only(['name', 'address', 'cp', 'city', 'country', 'phone', 'portable', 'fax', 'email', 'web'])
                );

            toastr()->success("Données mise à jour");
        }catch (\Exception $e){
            toastr()->error($e->getMessage());
        }
    }

    public function saveInfo()
    {
        try {
            $this->company->info->update(
                $this->only(['director', 'capital', 'type', 'object', 'num_tva', 'num_siren', 'num_siret', 'num_naf', 'rcs'])
            );
            toastr()->addSuccess('Données mise à jour');
        }catch (\Exception $e){
            toastr()->error($e->getMessage());
        }
    }

    public function saveTVA()
    {
        try {
            $this->company->info->update(
                $this->only(['tva'])
            );

            toastr()->success('TVA mise <UNK> jour');
        }catch (\Exception $e){
            toastr()->error($e->getMessage());
        }
    }

    public function saveLogo()
    {
        dd($this->all());
        try {
            $this->logo->storeAs(
                path: 'societe',
                name: 'logo_wide.png',
                options: 'minio'
            );
            toastr()->success('Logo mise <UNK> jour');
        }catch (\Exception $e){
            toastr()->error($e->getMessage());
        }
    }

    #[Title('Configuration de la société')]
    public function render()
    {
        cache()->put('mainmenu', $this->mainmenu);
        cache()->put('actualmenu', $this->actualmenu);

        return view('livewire.core.setting-company')
            ->layout('components.layouts.app');
    }
}
