<?php

namespace App\Livewire\Tiers\Fournisseur;

use Livewire\Attributes\Title;
use Livewire\Component;

class Show extends Component
{
    public string $mainmenu = 'tiers';
    public string $actualmenu = 'tiers.fournisseur.index';

    #[Title("Création d'un fournisseur")]
    public function render()
    {
        cache()->put('mainmenu', $this->mainmenu);
        cache()->put('actualmenu', $this->actualmenu);
        return view('livewire.tiers.fournisseur.show');
    }
}
