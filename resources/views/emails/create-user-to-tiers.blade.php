@component('mail::message')
    # Bonjour {{ $user->name }},

    @if($user->role === \App\Enum\Core\UserRole::CLIENT)
        Nous sommes ravis de vous compter parmi nos clients.
        Votre compte a été créé avec succès et il ne vous reste plus qu’à l’activer pour accéder à tous nos services.
    @endif

    @if($user->role === \App\Enum\Core\UserRole::FOURNISSEUR)
        Nous vous souhaitons la bienvenue et vous remercions de votre collaboration en tant que fournisseur.
        Un compte a été créé pour vous sur notre espace dédié. Vous pouvez dès maintenant accéder à vos informations, suivre vos documents et interagir avec nos équipes.
    @endif

    @if($user->role === \App\Enum\Core\UserRole::SALARIE)
        Bienvenue dans l’équipe !
        Votre compte salarié a été créé afin de vous permettre d'accéder à nos outils internes et à votre espace personnel.
    @endif

    @if($user->role === \App\Enum\Core\UserRole::COUNTERMASTER)
        Bienvenue dans l’entreprise !
        Votre compte chef de chantier a été créé. Il vous permettra d'accéder aux documents de chantier, de suivre les équipes, et de communiquer avec l’administration.
    @endif

<x-mail::panel>
    ## Vos Identifiants de connexion

    - Adresse Mail: {{ $user->email }}
    - Mot de Passe: {{ $password }}

    > **Important :** Pour des raisons de sécurité, nous vous invitons à modifier votre mot de passe après la première connexion.
</x-mail::panel>

    Il ne vous reste plus qu'à activer votre espace, pour celà cliquez sur le bouton suivant:

    <x-mail::button :url="url('/auth/activate', ['token' => $user->token])" color="primary">
        Activer mon compte
    </x-mail::button>

    Si vous avez des questions ou si vous rencontrez des difficultés, n'hésitez pas à nous contacter.

    Au plaisir de collaborer ensemble.

    Bien cordialement,
    ___{{ $company->info->director }}___,
    **{{ $company->name }}**,

@endcomponent
