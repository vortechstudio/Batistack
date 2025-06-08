<?php

namespace App\Livewire\Tiers\Fournisseur;

use App\Models\Tiers\Tiers;
use App\Models\Tiers\TiersLog;
use Filament\Actions\Action;
use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Actions\Contracts\HasActions;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Livewire\Attributes\Title;
use Livewire\Component;

class Show extends Component implements HasForms, HasTable, HasActions
{
    use InteractsWithForms;
    use InteractsWithTable;
    use InteractsWithActions;

    public string $mainmenu = 'tiers';
    public string $actualmenu = 'tiers.fournisseur.index';

    public Tiers $tiers;

    public ?array $dataMessages = [];

    public function mount(): void
    {
        $this->form->fill($this->tiers->attributesToArray());
    }

    public function table(Table $table): Table
    {
        return $table
            ->query(TiersLog::query()->where('tiers_id', $this->tiers->id)->orderByDesc('id')->limit(10)->newQuery())
            ->columns([
                TextColumn::make('id'),
                TextColumn::make('user.name'),
                TextColumn::make('libelle'),
            ]);
    }

    public function sendMessage(): Action
    {
        return Action::make('sendMessage')
            ->label("Envoyer un email")
            ->color('secondary')
            ->outlined()
            ->icon('heroicon-s-envelope')
            ->form([
                TextInput::make('objects')
                    ->label('Objets'),

                RichEditor::make('message')
                    ->label('Message'),

                FileUpload::make('attachments')
                    ->label('Pièces Jointes')
                    ->disk('public')
                    ->directory('sendingMessage')
                    ->visibility('private')
            ])
            ->action(function (array $data) {
                dd($data);
            });
    }

    public function editForm(): Action
    {
        return Action::make('editing')
            ->outlined()
            ->color('primary')
            ->icon('far-edit');
    }

    #[Title("Fiche du fournisseur")]
    public function render()
    {
        cache()->put('mainmenu', $this->mainmenu);
        cache()->put('actualmenu', $this->actualmenu);
        return view('livewire.tiers.fournisseur.show')
            ->layout('components.layouts.app');
    }
}
