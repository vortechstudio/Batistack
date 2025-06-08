<div class="card">
    <div class="card-header">
        <h3 class="card-title">Liste des fournisseurs</h3>
        <div class="card-toolbar">
            {{ $this->createFormAction }}
        </div>
    </div>
    <div class="card-body">
        <form wire:submit="create">
            {{ $this->table }}
        </form>
    </div>
    <x-filament-actions::modals />
</div>
