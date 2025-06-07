<div>
    <x-basic.alert
        type="basic"
        color="success"
        icon="fa-info-circle"
        title="Information à propos de l'aggrégation bancaire"
        text="L’agrégation bancaire est un service qui permet à un utilisateur de regrouper sur une seule interface toutes les informations de ses comptes bancaires ouverts dans différentes banques." />

    <div class="card card-flush bg-light mb-5">
        <div class="card-header">
            <h3 class="card-title"><i class="fa-solid fa-wallet me-2"></i> Comptes Connectés</h3>
            <div class="card-toolbar">
                <button wire:click="connectAccount" class="btn btn-success">Connecter une banque</button>
            </div>
        </div>
        <div class="card-body bg-white">
            @if(empty($company->info->bridge_client_id))
                <div class="d-flex justify-content-center align-items-center">
                    <div class="d-flex flex-column align-items-center">
                        <i class="fa-solid fa-wallet text-success fs-3hx"></i>
                        <span class="fs-2x text-success">Aucun compte synchronisée</span>
                    </div>
                </div>
            @else
                @livewire('core.setting-bank-card')
            @endif
        </div>
    </div>
</div>
