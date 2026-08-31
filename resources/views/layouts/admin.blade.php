<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>{{ $title ?? config('app.name') }}</title>

    @vite(['resources/css/admin.css', 'resources/js/app.js'])

    @livewireStyles
</head>

<body x-cloak x-data="{ darkMode: $persist(false) }" :class="darkMode && 'dark'">
    {{ $slot }}

    <span class="absolute bottom-0 right-0">
        <button class="rounded-full bg-gray-200 p-2 dark:bg-gray-800" @click="darkMode = !darkMode">
            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"></path>
            </svg>
        </button>
    </span>
    @livewireScripts
</body>

</html>
