<x-layouts.auth.simple :title="$title ?? null">
    @if(isset($slot) && !empty($slot))
        {{ $slot }}
    @else
        @yield('content')
    @endif
</x-layouts.auth.simple>
