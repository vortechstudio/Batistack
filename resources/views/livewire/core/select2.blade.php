<div wire:ignore>
    <select data-pharaonic="select2" data-component-id="{{ $this->__id }}" class="form-control" wire:model="{{ $model }}">
        <option value="">Selectionnez une valeur</option>
        @foreach($series as $k => $item)
            <option value="{{ $item }}">{{ $item }}</option>
        @endforeach
    </select>
</div>
@push('scripts')
    <script>
        $(document).ready(function () {
            let select = $("#select2");
            select.select2();
            select.on('change', function (e) {
                let data = select.select2("val");
                @this.set('selected', data);
            });
        });
    </script>
@endpush
