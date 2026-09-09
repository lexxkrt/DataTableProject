@props(['route', 'title', 'icon' => ''])
@php
    empty($icon) and ($icon = str($title)->substr(0, 2)->upper()->value());
    $active = request()->routeIs($route);
@endphp
<li><a href="{{ route($route) }}" @class([
    'flex items-center gap-2',
    'hover:bg-gray-600 dark:hover:bg-gray-800',
    'bg-gray-600 dark:bg-gray-800' => $active,
]) title="{{ __($title) }}" wire:navigate>
        <span class="flex size-8 items-center justify-center overflow-hidden rounded-lg border border-gray-500 bg-white/10">{{ $icon }}</span>
        {{ __($title) }}
    </a>
</li>
