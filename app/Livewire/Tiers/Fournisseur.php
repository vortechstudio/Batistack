<?php

namespace App\Livewire\Tiers;

use App\Models\Tiers\Tiers;
use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Actions\Contracts\HasActions;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Wizard\Step;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Tables\Actions\Action;
use Filament\Tables\Columns\CheckboxColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Livewire\Attributes\Title;
use Livewire\Component;

class Fournisseur extends Component implements HasForms, HasTable, HasActions
{
    use InteractsWithForms;
    use InteractsWithTable;
    use InteractsWithActions;

    public string $mainmenu = 'tiers';
    public string $actualmenu = 'tiers.fournisseur.index';

    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill();
    }

    public function createFormAction(): \Filament\Actions\Action
    {
        return \Filament\Actions\Action::make('create')
            ->button()
            ->label('Création')
            ->url(route('tiers.fournisseur.create'));
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([])
            ->statePath('data');
    }

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Tiers::query()
                ->where('nature', 'fournisseur')
                ->newQuery(),
            )
            ->columns([
                CheckboxColumn::make('checkin'),
                TextColumn::make('name')
                ->label('Nom du tier')
                ->searchable()
                ->sortable(),

                TextColumn::make('code_tiers')
                ->label('Code Fournisseur')
                ->searchable()
                ->sortable(),

                TextColumn::make('cp')
                ->label('Code Postal')
                ->searchable()
                ->sortable(),

                TextColumn::make('phone')
                ->label('Telephone')
                ->searchable(),

                TextColumn::make('type')
                ->label('Type du Tier')
            ]);
    }

    #[Title("Fournisseurs")]
    public function render()
    {
        cache()->put('mainmenu', $this->mainmenu);
        cache()->put('actualmenu', $this->actualmenu);
        return view('livewire.tiers.fournisseur')
            ->layout('components.layouts.app');
    }
}
