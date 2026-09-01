@props(['formSize' => 'max-w-md', 'title' => ''])
@php
    $size = match ($formSize) {
        'md' => 'max-w-md',
        'lg' => 'max-w-lg',
        'xl' => 'max-w-xl',
        '2xl' => 'max-w-2xl',
        '3xl' => 'max-w-3xl',
        '5xl' => 'max-w-5xl',
        default => $formSize,
    };
@endphp
<div x-cloak x-show="show" x-data="{ show: @entangle('formShow'), maximize: false }"
     x-trap.noscroll="show"
     class="fixed inset-0 z-40" x-on:keydown.escape.window="$dispatch('formClose')">
    <div class="fixed inset-0 z-40 h-screen w-full bg-black/30 backdrop-blur"></div>
    <div
         class="fixed inset-0 z-50 mx-auto my-10 h-screen w-full overflow-y-auto"
         :class="{
             '{{ $size }}': !maximize,
             'w-full my-0!': maximize,
         }">
        <div class="absolute right-1 top-1 flex items-center justify-end">
            <span class="cursor-pointer rounded p-1 hover:bg-gray-100 dark:hover:bg-slate-900/50" x-on:click="maximize = !maximize">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4">
                    <path :class="maximize && 'hidden'" stroke-linecap="round" stroke-linejoin="round"
                          d="M3.75 3.75v4.5m0-4.5h4.5m-4.5 0L9 9M3.75 20.25v-4.5m0 4.5h4.5m-4.5 0L9 15M20.25 3.75h-4.5m4.5 0v4.5m0-4.5L15 9m5.25 11.25h-4.5m4.5 0v-4.5m0 4.5L15 15" />
                    <path :class="!maximize && 'hidden'" stroke-linecap="round" stroke-linejoin="round"
                          d="M9 9V4.5M9 9H4.5M9 9 3.75 3.75M9 15v4.5M9 15H4.5M9 15l-5.25 5.25M15 9h4.5M15 9V4.5M15 9l5.25-5.25M15 15h4.5M15 15v4.5m0-4.5 5.25 5.25" />
                </svg>
            </span>
            <span class="cursor-pointer rounded p-1 hover:bg-gray-100 dark:hover:bg-slate-900/50" x-on:click="$dispatch('formClose')">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                </svg>
            </span>
        </div>
        <div class="mb-10 rounded-lg bg-gray-200 p-5 shadow-lg dark:bg-gray-700" :class="{ 'h-[-webkit-fill-available] mb-0!': maximize }">
            @if ($title)
                <h3 class="mb-3 text-lg font-bold">{{ $title }}</h3>
            @endif
            {{ $slot }}
        </div>
    </div>
</div>
