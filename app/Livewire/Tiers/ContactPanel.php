<?php

namespace App\Livewire\Tiers;

use App\Enum\Core\UserRole;
use App\Helpers\Helpers;
use App\Models\Tiers\Tiers;
use App\Models\Tiers\TiersContact;
use App\Models\User;
use App\Notifications\Core\CreateUserToTiersNotification;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Tables\Actions\Action;
use Filament\Tables\Columns\Column;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Livewire\Component;

class ContactPanel extends Component implements HasForms, HasTable
{
    use InteractsWithForms;
    use InteractsWithTable;

    public Tiers $tiers;
    public ?array $dataContact = [];

    public function table(Table $table): Table
    {
        return $table
            ->heading("Liste des Contacts")
            ->query($this->tiers->contacts()->getQuery())
            ->headerActions([
                Action::make('createContact')
                    ->label('Ajouter')
                    ->icon('heroicon-o-plus')
                    ->color('primary')
                    ->form([
                        Section::make()
                            ->columns([
                                'sm' => 1,
                                'md' => 3,
                                'lg' => 12
                            ])
                            ->schema([
                                Select::make('titre')
                                    ->label('Titre')
                                    ->options([
                                        "Monsieur" => "Monsieur",
                                        "Madame" => "Madame",
                                        "Mademoiselle" => "Mademoiselle",
                                    ])
                                    ->columnSpan(['sm' => 1, "md" => 1, "lg" => 3]),

                                TextInput::make('nom')
                                    ->label('Nom')
                                    ->columnSpan(['sm' => 1, "md" => 1, "lg" => 3]),

                                TextInput::make('prenom')
                                    ->label('Prénom')
                                    ->columnSpan(['sm' => 1, "md" => 1, "lg" => 3]),

                                TextInput::make('poste')
                                    ->label('Poste')
                                    ->columnSpan(['sm' => 1, "md" => 1, "lg" => 3]),

                                TextInput::make('phone')
                                    ->label('Téléphone')
                                    ->columnSpan(['sm' => 1, "md" => 1, "lg" => 4])
                                    ->prefixIcon('forkawesome-phone'),

                                TextInput::make('portable')
                                    ->label('Mobile')
                                    ->columnSpan(['sm' => 1, "md" => 1, "lg" => 4])
                                    ->prefixIcon('forkawesome-mobile'),

                                TextInput::make('email')
                                    ->label('Adresse Mail')
                                    ->columnSpan(['sm' => 1, "md" => 1, "lg" => 4])
                                    ->prefixIcon('forkawesome-envelope'),

                                Toggle::make('has_account')
                                    ->label('Créer un compte utilisateur'),
                            ])
                    ])
                    ->action(function (array $data, TiersContact $contact) {
                        $this->storeContact($data, $contact);
                    }),
            ])
            ->columns([
                TextColumn::make('id')
                    ->label("#"),

                TextColumn::make("nom")
                    ->label("Identité")
                    ->formatStateUsing(fn(string $state, Column $column) => $column->getRecord()['titre'] . " " . $column->getRecord()['nom'] . " " . $column->getRecord()['prenom']),

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
                    ->action(fn(Model $action) => $this->redirectRoute('apps.call', ['phone' => $action->phone])),
            ]);
    }

    public function storeContact(array $data, TiersContact $contact): void
    {
        try {
            $cpt = $contact->create([
                'titre' => $data['titre'],
                'poste' => $data['poste'],
                'nom' => $data['nom'],
                'prenom' => $data['prenom'],
                'phone' => $data['phone'],
                'email' => $data['email'],
                'portable' => $data['portable'],
                'tiers_id' => $this->tiers->id
            ]);

            if ($data['has_account']) {
                $password = Helpers::generatePassword();
                $contact = $this->tiers->contacts()->orderBy('id', "DESC")->first();
                try {
                    $user = User::create([
                        'name' => $data['nom'] . " " . $data['prenom'],
                        "email" => $data['email'],
                        "password" => \Hash::make($password),
                        "role" => UserRole::FOURNISSEUR,
                        "blocked" => true,
                        'tiers_id' => $contact->id,
                        'token' => Str::random(35),
                    ]);

                    try {
                        $user = User::orderBy('id', "DESC")->first();
                        $user->notify(new CreateUserToTiersNotification($user, $password));
                    }catch (\Throwable $th) {
                        \Log::emergency($th);
                        toastr()->addError("Erreur lors de l'envoie du mail de bienvenue");
                    }
                }catch (\Throwable $th) {
                    \Log::emergency($th);
                    toastr()->addError("Erreur lors de l'enregistrement de l'utilisateur");
                }
            }

            $this->tiers->logs()->create([
                "libelle" => "Création du contact: ".$cpt->titre." ".$cpt->nom." ".$cpt->prenom,
                "user_id" => auth()->user()->id,
                "tiers_id" => $this->tiers->id
            ]);
            toastr()->success("Le contact à été créer avec succès !");

        }catch (\Exception $e){
            \Log::emergency("File:" . $e->getFile(). "Line:" . $e->getLine(). "Message:" . $e->getMessage());
            toastr()->addError('Erreur lors de l\'enregistrement', [], 'Erreur');
        }
    }

    public function render()
    {
        return view('livewire.tiers.contact-panel');
    }
}
