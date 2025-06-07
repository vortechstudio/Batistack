@if($type == 'basic')
    <div class="alert alert-{{ $color }} d-flex align-items-center p-5">
        <i class="fa-solid {{ $icon }} fs-2hx text-{{ $color }} me-4"></i>
        <div class="d-flex flex-column">
            <h4 class="mb-1 text-dark">{{ $title }}</h4>
            <span>{{ $text }}</span>
        </div>
    </div>
@endif
