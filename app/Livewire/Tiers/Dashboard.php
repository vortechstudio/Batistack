<?php

namespace App\Livewire\Tiers;

use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Livewire\Attributes\Title;
use Livewire\Component;

class Dashboard extends Component
{

    public string $mainmenu = 'tiers';
    public string $actualmenu = 'tiers.dashboard';

    #[Title("Tableau de Bord")]
    public function render()
    {
        cache()->put('mainmenu', $this->mainmenu);
        cache()->put('actualmenu', $this->actualmenu);

        return view('livewire.tiers.dashboard')
            ->layout('components.layouts.app');
    }
}
