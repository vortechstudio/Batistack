<?php

namespace App\Livewire\Apps;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Livewire\Attributes\Title;
use Livewire\Component;

class Calling extends Component
{
    public string $mainmenu = 'apps';
    public string $actualmenu = 'apps.call';
    public string $phone;

    public function mount(Request $request): void
    {
        $this->phone = Str::replace('0', '+33', Str::replace(' ', '', $request->phone));
    }

    #[Title("Contact Softphone")]
    public function render()
    {
        return view('livewire.apps.calling')
            ->layout('components.layouts.app');
    }
}
