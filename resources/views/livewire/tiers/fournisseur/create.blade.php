<div class="card card-flush bg-light shadow-sm">
    <div class="card-header">
        <h3 class="card-title">Création d'un tiers</h3>
    </div>
    <div class="card-body bg-white">
        <form wire:submit.prevent="submit">
            {{ $this->form }}
        </form>
    </div>
</div>
