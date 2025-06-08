<?php

namespace App\Livewire\Widget\Tiers;

use App\Enum\Tiers\Nature;
use App\Models\Tiers\Tiers;
use Filament\Widgets\ChartWidget;
use Flowframe\Trend\Trend;

class ChartTiers extends ChartWidget
{
    protected static ?string $heading = 'Statistiques';

    protected function getData(): array
    {
        $client = Tiers::where('nature', 'client')
            ->count();
        $fournisseur = Tiers::where('nature', 'fournisseur')
            ->count();

        return [
            "datasets" => [
                [
                    "label" => "Clients",
                    "data" => $client,
                    'backgroundColor' => '#36A2EB',
                ],
                [
                    "label" => "Fournisseurs",
                    "data" => $fournisseur,
                    'backgroundColor' => '#FFF',
                ]
            ],
            "labels" => ["Clients", "Fournisseurs"],
        ];
    }

    protected function getType(): string
    {
        return 'pie';
    }
}
