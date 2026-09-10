<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>{{ $title ?? config('app.name') }}</title>

    @vite(['resources/css/auth.css', 'resources/js/app.js'])

    @livewireStyles
</head>

<body x-cloak
      x-data="{ darkMode: $persist(false) }"
      :class="darkMode && 'dark'">
    <div class="absolute bottom-0 right-0">
        <x-dark-mode-toggler />
    </div>
    {{ $slot }}

    @livewireScripts
</body>

</html>