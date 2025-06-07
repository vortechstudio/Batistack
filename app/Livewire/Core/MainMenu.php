<?php

namespace App\Livewire\Core;

use Livewire\Component;

class MainMenu extends Component
{
    public string $mainmenu = '';
    public string $actualmenu = '';

    public function mount()
    {
        $this->mainmenu = cache()->get('mainmenu');
        $this->actualmenu = cache()->get('actualmenu');
    }
    public function render()
    {
        return view('livewire.core.main-menu');
    }
}
