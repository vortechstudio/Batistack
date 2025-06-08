<?php

namespace App\Livewire\Tiers\Fournisseur;

use App\Enum\Tiers\Nature;
use App\Enum\Tiers\Type;
use App\Models\Core\City;
use App\Models\Core\ConditionReglement;
use App\Models\Core\Country;
use App\Models\Core\ModeReglement;
use App\Models\Core\PlanComptable;
use App\Models\Tiers\Tiers;
use App\Models\Tiers\TiersAddress;
use App\Models\Tiers\TiersBanque;
use App\Models\Tiers\TiersContact;
use App\Models\Tiers\TiersFournisseur;
use App\Rules\Siren;
use App\Services\Bridges\Api;
use App\Services\Search;
use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Actions\Contracts\HasActions;
use Filament\Forms\Components\Repeater;
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
use Illuminate\Support\HtmlString;
use Intervention\Validation\Rules\Bic;
use Intervention\Validation\Rules\Iban;
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
        $api = new Api();
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
                                ->default("FOU-00".rand(1,9999))
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
                                ->columnSpan(["sm" => 1, "md" => 1, "lg" => 3])
                                ->options(fn (Get $get) => $get('cp') ? City::where('postal_code', $get('cp'))->pluck('cities.city', 'cities.city')->toArray() : City::get()->pluck('city', 'postal_code')->toArray()),

                            Select::make('pays')
                                ->label('Pays')
                                ->searchable()
                                ->required()
                                ->columnSpan(["sm" => 1, "md" => 1, "lg" => 2])
                                ->options(fn () => Country::get()->pluck('name', 'name')->toArray()),
                        ]),

                    Step::make('Contact')
                        ->description("Information de contact au sein de l'entreprise")
                        ->columns([
                            "sm" => 1,
                            "md" => 3,
                            "lg" => 6,
                        ])
                        ->schema([
                            TextInput::make('nom')
                                ->label('Nom')
                                ->columnSpan(["sm" => 1, "md" => 1, "lg" => 2]),

                            TextInput::make('prenom')
                                ->label('Prénom')
                                ->columnSpan(["sm" => 1, "md" => 1, "lg" => 2]),

                            Select::make('titre')
                                ->label("Civilité")
                                ->options([
                                    "Monsieur" =>  "Monsieur",
                                    "Madame" =>  "Madame",
                                    "Mademoiselle" =>  "Mademoiselle",
                                ])
                                ->columnSpan(["sm" => 1, "md" => 1, "lg" => 2]),

                            TextInput::make('poste')
                                ->label('Poste'),

                            TextInput::make('phone')
                                ->prefixIcon('heroicon-s-phone')
                                ->columnSpan(["sm" => 1, "md" => 1, "lg" => 2])
                                ->mask('99 99 99 99 99')
                                ->label('Téléphone'),

                            TextInput::make('portable')
                                ->prefixIcon('bi-phone-fill')
                                ->columnSpan(["sm" => 1, "md" => 1, "lg" => 2])
                                ->mask('99 99 99 99 99')
                                ->label('Portable'),

                            TextInput::make('email')
                                ->email()
                                ->prefixIcon('entypo-email')
                                ->columnSpan(["sm" => 1, "md" => 1, "lg" => 2])
                                ->label('Adresse Email'),
                        ]),

                    Step::make('Fournisseur')
                        ->description("Information dédié au fournisseur")
                        ->columnSpan(["sm" => 1, "md" => 3, "lg" => 6])
                        ->schema([
                            TextInput::make('code_comptable_fournisseur')
                                ->label('Code Comptable Fournisseur')
                                ->mask("401aaaaaaaaaaaaa"),

                            Select::make('condition_rglt')
                                ->label("Condition de règlement")
                                ->options(fn () => ConditionReglement::get()->pluck('libelle', 'code')->toArray()),

                            Select::make('mode_rglt')
                                ->label('Mode de règlement')
                                ->options(fn () => ModeReglement::get()->pluck('libelle', 'code')->toArray()),

                            TextInput::make('rem_relative')
                                ->label("Remise Relative")
                                ->columnSpan(["sm" => 1, "md" => 1, "lg" => 3])
                                ->suffix("%"),

                            TextInput::make('rem_fixe')
                                ->label("Remise Fixe")
                                ->columnSpan(["sm" => 1, "md" => 1, "lg" => 3])
                                ->suffix("%"),

                            Select::make('code_comptabilite_gen')
                                ->label("Plan Comptable général")
                                ->options(fn () => PlanComptable::whereBetween('compte', ["4", "5"])->get()->pluck('libelle', 'compte')->toArray()),
                        ]),

                    Step::make('Banque')
                        ->description("Information bancaire")
                        ->columnSpan(["sm" => 1, "md" => 1, "lg" => 12])
                        ->schema([
                            TextInput::make('libelle')
                                ->label('Libelle')
                                ->columnSpan(["sm" => 1, "md" => 1, "lg" => 12]),

                            Select::make('banque')
                                ->label("Nom de la Banque")
                                ->searchable()
                                ->options(Api::getProvidersToSelect())
                                ->columnSpan(["sm" => 1, "md" => 1, "lg" => 12])
                                ->allowHtml(),

                            TextInput::make('code_banque')
                                ->label('Code Banque')
                                ->mask("99999")
                                ->columnSpan(["sm" => 1, "md" => 1, "lg" => 3]),

                            TextInput::make('code_guichet')
                                ->label('Code Guichet')
                                ->mask("99999")
                                ->columnSpan(["sm" => 1, "md" => 1, "lg" => 3]),

                            TextInput::make('num_compte')
                                ->label('Numéro de compte')
                                ->mask("99999999999999999999")
                                ->columnSpan(["sm" => 1, "md" => 1, "lg" => 3]),

                            TextInput::make('cle')
                                ->label('Cle RIB')
                                ->mask("99")
                                ->columnSpan(["sm" => 1, "md" => 1, "lg" => 3]),

                            TextInput::make('iban')
                                ->label('IBAN')
                                ->rules([new Iban()])
                                ->columnSpan(["sm" => 1, "md" => 1, "lg" => 9]),

                            TextInput::make('bic')
                                ->label('BIC/SWIFT')
                                ->rules([new Bic()])
                                ->columnSpan(["sm" => 1, "md" => 1, "lg" => 3]),


                        ])
                ])
                ->submitAction(new HtmlString('<button type="submit" class="btn btn-sm btn-primary">Créer un tiers</button>'))
            ])->statePath('data');
    }

    public function submit()
    {
        $data = $this->form->getState();
        Tiers::create([
            "name" => $data['name'],
            "nature" => $data['nature'],
            "type" =>  $data['type'],
            "code_tiers" =>  $data['code_tiers'],
            "siren"  => $data['siren'],
            "siret"  => $data['siret'],
            "tva" =>  $data['tva'],
            "num_tva" => $data['tva'] ? $data['num_tva'] : null,
        ]);

        $tiers = Tiers::orderBy('id', 'DESC')->limit(1)->first();

        TiersAddress::create([
            'address' =>  $data['address'],
            'cp' =>   $data['cp'],
            'ville' =>  $data['ville'],
            'pays' =>   $data['pays'],
            'tiers_id' =>  $tiers->id,
        ]);

        if($data['nom'] !== null) {
            TiersContact::create([
                "nom" =>  $data['nom'],
                "prenom" =>  $data['prenom'],
                "titre" =>   $data['titre'],
                "phone" =>   $data['phone'],
                "portable" =>   $data['portable'],
                "email" =>   $data['email'],
                "tiers_id" =>   $tiers->id,
            ]);
        }

        if($data['code_comptable_fournisseur'] !== null) {
            TiersFournisseur::create([
                "code_comptable_fournisseur" =>   $data['code_comptable_fournisseur'],
                "condition_rglt" =>    $data['condition_rglt'],
                "mode_rglt" =>   $data['mode_rglt'],
                "rem_fixe" =>    $data['rem_fixe'],
                "rem_relative" =>   $data['rem_relative'],
                "code_comptabilite_gen" =>    $data['code_comptabilite_gen'],
                "tiers_id" =>    $tiers->id,
            ]);
        }

        if($data['libelle'] !== null) {
            TiersBanque::create([
                "libelle" =>  $data['libelle'],
                "banque" =>   $data['banque'],
                "code_banque" =>   $data['code_banque'],
                "code_guichet" =>   $data['code_guichet'],
                "num_compte" =>   $data['num_compte'],
                "cle" =>   $data['cle'],
                "iban" =>   $data['iban'],
                "bic" =>   $data['bic'],
                "tiers_id" =>    $tiers->id,
            ]);
        }

        $tiers->logs()->create([
            "libelle" => "Création du tiers: ".$tiers->name,
            "user_id" => auth()->user()->id,
            "tiers_id" => $tiers->id,
        ]);
        toastr()->addSuccess("Le tiers à été créer avec succès");
        $this->redirect(route('tiers.fournisseur.index'));
    }

    #[Title("Création d'un fournisseur")]
    public function render()
    {
        cache()->put('mainmenu', $this->mainmenu);
        cache()->put('actualmenu', $this->actualmenu);

        return view('livewire.tiers.fournisseur.create');
    }
}
