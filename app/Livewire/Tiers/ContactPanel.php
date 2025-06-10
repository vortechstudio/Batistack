<?php

namespace App\Livewire\Tiers;

use App\Models\Tiers\Tiers;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Tables\Actions\Action;
use Filament\Tables\Columns\Column;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;
use Livewire\Component;

class ContactPanel extends Component implements HasForms, HasTable
{
    use InteractsWithForms;
    use InteractsWithTable;

    public Tiers $tiers;

    public function table(Table $table): Table
    {
        return $table
            ->heading("Liste des Contacts")
            ->query($this->tiers->contacts()->getQuery())
            ->columns([
                TextColumn::make('id')
                    ->label("#"),

                TextColumn::make("nom")
                    ->label("Identité")
                    ->formatStateUsing(fn (string $state, Column $column) => $column->getRecord()['titre']." ".$column->getRecord()['nom']." ".$column->getRecord()['prenom']),

                TextColumn::make("poste")
                    ->label('Poste'),

                TextColumn::make("phone")
                    ->label('Téléphone'),

                TextColumn::make("email")
                    ->label('Adresse Mail'),
            ])
            ->actions([
                Action::make('call')
                    ->icon('heroicon-s-phone')
                    ->requiresConfirmation()
                    ->action(fn (Model $action) => $this->redirectRoute('apps.call', ['phone' => $action->phone])),
            ]);
    }

    public function render()
    {
        return view('livewire.tiers.contact-panel');
    }
}
