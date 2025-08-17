<x-layouts.auth.simple :title="$title ?? null">
    @if($slot->isNotEmpty())
        {{ $slot }}
    @else
        @yield('content')
    @endif
</x-layouts.auth.simple>
