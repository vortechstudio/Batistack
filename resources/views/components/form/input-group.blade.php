<div class="mb-5">
    <label for="{{ $name }}" class="{{ $required ? 'required' : '' }} form-label">{{ $label }}</label>


    @if($iconPlacement == 'left')
        <div class="input-group mb-5">
            <span class="input-group-text" id="basic-addon1">
                <i class="fa-solid {{ $icon }} fs-1"></i>
            </span>
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
    @endif

    @if($iconPlacement == 'right')
        <div class="input-group mb-5">
            <input
                type="{{ $type }}"
                class="form-control"
                @if($live) wire:model.change="{{ $name }}" @else wire:model="{{ $name }}" @endif
                placeholder="{{ $placeholder ?? $label }}"
                @if($required) required @endif
                @if($disabled) disabled @endif
                @if($mask) data-inputmask="'mask': '{{ $maskValue }}'" @endif

            />
            <span class="input-group-text" id="basic-addon1">
                <i class="fa-solid {{ $icon }} fs-1"></i>
            </span>
        </div>
    @endif
</div>
