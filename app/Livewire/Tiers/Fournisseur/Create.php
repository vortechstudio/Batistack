<?php

namespace App\Livewire\Tiers\Fournisseur;

use App\Enum\Tiers\Nature;
use App\Enum\Tiers\Type;
use App\Models\Core\City;
use App\Rules\Siren;
use App\Services\Search;
use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Actions\Contracts\HasActions;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Wizard;
use Filament\Forms\Components\Wizard\Step;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Livewire\Attributes\Title;
use Livewire\Component;

class Create extends Component implements HasForms, HasActions
{
    use InteractsWithForms;
    use InteractsWithActions;

    public string $mainmenu = 'tiers';
    public string $actualmenu = 'tiers.fournisseur.index';

    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill();
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Wizard::make([
                    Step::make('Identité')
                        ->description("Information sur l'identité")
                        ->schema([
                            TextInput::make('name')
                                ->label('Raison Social')
                                ->required(),

                            Select::make('nature')
                                ->label("Nature de l'entreprise")
                                ->required()
                                ->options(Nature::class)
                                ->searchable(),

                            Select::make('type')
                                ->label("Type d'entreprise")
                                ->required()
                                ->options(Type::array())
                                ->searchable(),

                            TextInput::make('code_tiers')
                                ->label('Code Tiers')
                                ->mask("4011aaaaaaaaaaaaaaaa")
                                ->required(),

                            TextInput::make('siren')
                                ->label('SIREN')
                                ->mask("999 999 999")
                                ->rules([new Siren()])
                                ->required(),

                            TextInput::make('siret')
                                ->label('SIRET')
                                ->mask("999 999 999 99999")
                                ->required(),

                            Toggle::make('tva')
                                ->live()
                                ->label("Assujesti à la TVA"),

                            TextInput::make('num_tva')
                                ->label('Numero TVA')
                                ->mask("FR99 999 999 999")
                                ->hidden(fn (Get $get): bool => !$get('tva'))
                        ]),

                    Step::make('Adresse')
                        ->description("Adresse de l'entreprise")
                        ->columns([
                            "sm" => 1,
                            "md" => 3,
                            "lg" => 6,
                        ])
                        ->schema([
                            Textarea::make('address')
                                ->label('Adresse Postal')
                                ->required()
                                ->columnSpan(["sm" => 1, "lg" => 6]),

                            TextInput::make('cp')
                                ->live()
                                ->label('Code Postal')
                                ->mask("99999")
                                ->required()
                                ->columnSpan(["sm" => 1, "md" => 1, "lg" => 2]),

                            Select::make('ville')
                                ->label("Ville")
                                ->searchable()
                                ->required()
                                ->columnSpan(["sm" => 1, "md" => 2, "lg" => 4])
                                ->options(fn (Get $get) => $get('cp') ? City::where('postal_code', $get('cp'))->pluck('cities.city', 'cities.city')->toArray() : City::get()->pluck('city', 'postal_code')->toArray()),
                        ])
                ])
            ])->statePath('data');
    }

    #[Title("Création d'un fournisseur")]
    public function render()
    {
        cache()->put('mainmenu', $this->mainmenu);
        cache()->put('actualmenu', $this->actualmenu);

        return view('livewire.tiers.fournisseur.create');
    }
}
