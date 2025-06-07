<?php

namespace App\Livewire\Core;

use App\Models\Core\BanqueAggregate;
use Livewire\Component;

class SettingBankCard extends Component
{
    public $banks;

    public function mount(): void
    {
        $this->banks = BanqueAggregate::all();
    }
    public function render()
    {
        return view('livewire.core.setting-bank-card');
    }
}
