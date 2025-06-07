<?php

namespace App\Livewire\Core;

use Livewire\Component;

class Dashboard extends Component
{
    public string $mainmenu = 'core';
    public string $actualmenu = 'core.dashboard';
    public function render()
    {
        cache()->put('mainmenu', $this->mainmenu);
        cache()->put('actualmenu', $this->actualmenu);
        return view('livewire.core.dashboard')
            ->layout('components.layouts.app');
    }
}
