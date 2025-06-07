@if($type == 'simple')
    <div class="mb-5">
        <label for="{{ $name }}" class="{{ $required ? 'required' : '' }} form-label">{{ $label }}</label>
        <textarea class="form-control" wire:model="{{ $name }}" cols="5"></textarea>
    </div>
@endif
