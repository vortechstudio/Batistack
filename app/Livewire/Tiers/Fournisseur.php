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
use Illuminate\Support\Str;
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
                    ->with('addresses', 'contacts')
                ->newQuery(),
            )
            ->columns([
                TextColumn::make('name')
                ->label('Nom du tier')
                ->searchable()
                ->sortable(),

                TextColumn::make('code_tiers')
                ->label('Code Fournisseur')
                ->searchable()
                ->sortable(),

                TextColumn::make('addresses.cp')
                ->label('Code Postal')
                ->searchable()
                ->sortable(),

                TextColumn::make('contacts.phone')
                ->label('Telephone')
                ->searchable(),

                TextColumn::make('type')
                    ->label('Type du Tier')
                    ->formatStateUsing(fn ($state) => Str::ucfirst($state->label()))

            ])
            ->actions([
                Action::make('view')
                    ->icon('heroicon-s-eye')
                    ->iconSize('lg')
                    ->color('primary')
                    ->label('')
                    ->url(fn (Tiers $tiers) => route('tiers.fournisseur.show', $tiers)),

                Action::make('edit')
                    ->icon('heroicon-s-pencil')
                    ->iconSize('lg')
                    ->color('info')
                    ->label(''),

                Action::make('delete')
                    ->icon('heroicon-s-trash')
                    ->iconSize('lg')
                    ->requiresConfirmation()
                    ->modalHeading("Suppression du fournisseur")
                    ->modalDescription("Etes-vous sur de vouloir supprimer le fournisseur ?")
                    ->color('danger')
                    ->label('')
                    ->action(fn (Tiers $tiers) => $tiers->delete()),
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
