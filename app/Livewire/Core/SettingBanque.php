<?php

namespace App\Livewire\Core;

use App\Models\Core\Company;
use App\Services\Bridges\Api;
use Livewire\Attributes\Title;
use Livewire\Component;

class SettingBanque extends Component
{
    public string $mainmenu = 'core';
    public string $actualmenu = 'core.settings.banque';
    public Company $company;

    public function mount()
    {
        $this->company = Company::first();
    }

    public function connectAccount()
    {
        $bridge = new Api();

        if (!$this->company->info->bridge_client_id) {
            $user_account = $bridge->post('aggregation/users', [
                "external_user_id" => "USER".auth()->user()->id,
            ]);
            $this->company->info->update(['bridge_client_id' => $user_account['uuid']]);
        }

        $authToken = $bridge->post('aggregation/authorization/token', [
            'user_uuid' => $this->company->info->bridge_client_id,
        ]);
        cache()->put('bridge_access_token', $authToken['access_token']);

        $session = $bridge->post('aggregation/connect-sessions', [
            'user_email' => $this->company->email,
            'country_code' => "FR",
            'callback_url' => config('app.url').'/aggregate/callback',
        ], $authToken['access_token']);

        $this->redirect($session['url']);
    }

    #[Title('Aggrégation bancaire')]
    public function render()
    {
        cache()->put('mainmenu', $this->mainmenu);
        cache()->put('actualmenu', $this->actualmenu);

        return view('livewire.core.setting-banque')
            ->layout('components.layouts.app');
    }
}
