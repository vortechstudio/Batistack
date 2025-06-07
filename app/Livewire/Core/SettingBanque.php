<?php

namespace App\Livewire\Core;

use App\Models\Core\Company;
use Livewire\Attributes\Title;
use Livewire\Component;

class SettingBanque extends Component
{
    public string $mainmenu = 'core';
    public string $actualmenu = 'core.settings.banque';
    public Company $company;

    #[Title('Aggrégation bancaire')]
    public function render()
    {
        cache()->put('mainmenu', $this->mainmenu);
        cache()->put('actualmenu', $this->actualmenu);

        return view('livewire.core.setting-banque')
            ->layout('components.layouts.app');
    }
}
