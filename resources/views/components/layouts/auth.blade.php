<x-layouts.auth.simple :title="$title ?? null">
    @isset($slot)
        {{ $slot }}
    @else
        @yield('content')
    @endisset
</x-layouts.auth.simple>
