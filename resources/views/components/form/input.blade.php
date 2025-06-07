<div class="mb-5">
    <label for="{{ $name }}" class="{{ $required ? 'required' : '' }} form-label">{{ $label }}</label>
    <input
        type="{{ $type }}"
        class="form-control"
        @if($live) wire:model.change="{{ $name }}" @else wire:model="{{ $name }}" @endif
        placeholder="{{ $placeholder ?? $label }}"
        @if($required) required @endif
        @if($disabled) disabled @endif
        @if($mask) data-inputmask="'mask': '{{ $maskValue }}'" @endif

    />
</div>
