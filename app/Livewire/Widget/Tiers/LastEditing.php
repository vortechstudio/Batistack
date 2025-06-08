<?php

namespace App\Livewire\Widget\Tiers;

use App\Models\Tiers\Tiers;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class LastEditing extends BaseWidget
{
    protected static ?string $heading = "Derniers tiers modifié";
    public function table(Table $table): Table
    {
        return $table
            ->query(
                Tiers::query()
                    ->orderBy('id', 'desc')
                    ->limit(3)
                    ->newQuery()
            )
            ->columns([
                TextColumn::make('name')
                    ->label('Tier'),

                TextColumn::make('nature')
                    ->label('Type')
                    ->badge()
                    ->color(fn (Tiers $tier) => $tier->nature->color()),
            ]);
    }
}
