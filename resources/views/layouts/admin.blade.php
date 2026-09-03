<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>{{ $title ?? config('app.name') }}</title>

    @vite(['resources/css/admin.css', 'resources/js/app.js'])

    @livewireStyles
</head>

<body x-cloak x-data="{ darkMode: $persist(false), sidebarCollapsed: $persist(false) }" :class="darkMode && 'dark'" class="transition">
    <aside class="fixed bottom-0 left-0 top-0 bg-gray-400 transition-all dark:bg-gray-900" :class="sidebarCollapsed ? 'w-64' : 'w-12'">
        <div class="absolute right-3 top-3" x-on:click="sidebarCollapsed=!sidebarCollapsed">
            <svg x-show="sidebarCollapsed" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="m18.75 4.5-7.5 7.5 7.5 7.5m-6-15L5.25 12l7.5 7.5" />
            </svg>
            <svg x-show="!sidebarCollapsed" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="m5.25 4.5 7.5 7.5-7.5 7.5m6-15 7.5 7.5-7.5 7.5" />
            </svg>
        </div>
        <div class="mx-3 mt-12 border-b">
            <div class="inline-flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M14.25 9.75 16.5 12l-2.25 2.25m-4.5 0L7.5 12l2.25-2.25M6 20.25h12A2.25 2.25 0 0 0 20.25 18V6A2.25 2.25 0 0 0 18 3.75H6A2.25 2.25 0 0 0 3.75 6v12A2.25 2.25 0 0 0 6 20.25Z" />
                </svg>
                <span x-show="sidebarCollapsed" class="text-nowrap text-xl font-bold leading-4">
                    {{ __('Admin Panel') }}
                </span>
            </div>
        </div>
        <div class="mx-3 mt-3">
            <div class="inline-flex items-center gap-2">
                <x-admin.side-link route="admin.dashboard" title="{{ __('Dashboard') }}">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M20.25 6.375c0 2.278-3.694 4.125-8.25 4.125S3.75 8.653 3.75 6.375m16.5 0c0-2.278-3.694-4.125-8.25-4.125S3.75 4.097 3.75 6.375m16.5 0v11.25c0 2.278-3.694 4.125-8.25 4.125s-8.25-1.847-8.25-4.125V6.375m16.5 0v3.75m-16.5-3.75v3.75m16.5 0v3.75C20.25 16.153 16.556 18 12 18s-8.25-1.847-8.25-4.125v-3.75m16.5 0c0 2.278-3.694 4.125-8.25 4.125s-8.25-1.847-8.25-4.125" />
                    </svg>
                    <div x-show="sidebarCollapsed" class="">
                        {{ __('Dashboard') }}
                    </div>
                </x-admin.side-link></li>
            </div>
            <ul>
                <li><x-admin.side-link route="admin.brands" title="{{ __('Brands') }}" /></li>
                <li><x-admin.side-link route="admin.categories" title="{{ __('Categories') }}" /></li>
                <li><x-admin.side-link route="admin.products" title="{{ __('Products') }}" /></li>
            </ul>
        </div>

        <span class="absolute bottom-0 right-0">
            <button class="rounded-full bg-gray-200 p-2 dark:bg-gray-800" x-on:click="darkMode = !darkMode">
                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"></path>
                </svg>
            </button>
        </span>
    </aside>
    <div class="flex-1 transition-all duration-300" :class="sidebarCollapsed ? 'ml-64' : 'ml-12'">
        <header></header>
        <main class="p-5">
            {{ $slot }}
        </main>
        <div id="modal"></div>
        <footer></footer>
    </div>

    @livewireScripts
</body>

</html>
