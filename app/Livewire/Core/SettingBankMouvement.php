<?php

namespace App\Livewire\Core;

use App\Jobs\Core\AggregateBankMouvement;
use App\Models\Core\BanqueAggregateAccount;
use App\Models\Core\BanqueAggregateMouvement;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Livewire\Component;

class SettingBankMouvement extends Component implements HasForms, HasTable
{
    use InteractsWithForms;
    use InteractsWithTable;

    public BanqueAggregateAccount $account;
    public $mouvements;

    public function mount(BanqueAggregateAccount $account): void
    {
        $this->account = $account;
    }

    public function table(Table $table)
    {
        return $table
            ->query($this->account->mouvements()->getQuery()->where('future', false)->newQuery())
            ->columns([
                TextColumn::make('title')
                    ->label('Libellé')
                    ->searchable()
                    ->description(fn (BanqueAggregateMouvement $record): string => $record->description),
                TextColumn::make('date')
                    ->sortable(),
                TextColumn::make('amount')
                    ->label('Montant')
                    ->badge()
                    ->money('EUR')
                    ->color(fn (BanqueAggregateMouvement $record): string => $record->amount >= 0 ? 'primary' : 'danger'),
            ]);
    }

    public function render()
    {
        return view('livewire.core.setting-bank-mouvement');
    }
}
