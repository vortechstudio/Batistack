<?php

namespace App\Livewire\Core;

use Livewire\Attributes\On;
use Livewire\Component;

class Select2 extends Component
{
    public $selected = '';
    public array $series = [];
    public string $model = '';

    public function mount(array|null $series = [], string $model = ''): void
    {
        $this->series = $series;
        $this->model = $model;
    }

    #[On('search-city')]
    public function updateSeries($series)
    {
        $this->series = $series;
        $this->dispatch('refreshSelect2'); // Déclenche la réinitialisation
    }

    #[On('refresh')]
    public function refresh()
    {
        return;
    }

    public function render()
    {
        return view('livewire.core.select2');
    }
}
