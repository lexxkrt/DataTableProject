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
    <aside class="fixed bottom-0 left-0 top-0 w-64 p-5">
        <div class="mb-6 border-b border-b-gray-400 dark:border-b-gray-600">
            <div class="inline-flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M14.25 9.75 16.5 12l-2.25 2.25m-4.5 0L7.5 12l2.25-2.25M6 20.25h12A2.25 2.25 0 0 0 20.25 18V6A2.25 2.25 0 0 0 18 3.75H6A2.25 2.25 0 0 0 3.75 6v12A2.25 2.25 0 0 0 6 20.25Z" />
                </svg>
                <span class="text-nowrap text-xl font-bold leading-4">
                    {{ __('Admin Panel') }}
                </span>
            </div>
        </div>
        <div class="space-y-5">
            <x-admin.side-group title="{{ __('Dashboard') }}">
                <x-admin.side-link route="admin.home" title="{{ __('Dashboard') }}">
                    <x-slot:icon>
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                  d="M20.25 6.375c0 2.278-3.694 4.125-8.25 4.125S3.75 8.653 3.75 6.375m16.5 0c0-2.278-3.694-4.125-8.25-4.125S3.75 4.097 3.75 6.375m16.5 0v11.25c0 2.278-3.694 4.125-8.25 4.125s-8.25-1.847-8.25-4.125V6.375m16.5 0v3.75m-16.5-3.75v3.75m16.5 0v3.75C20.25 16.153 16.556 18 12 18s-8.25-1.847-8.25-4.125v-3.75m16.5 0c0 2.278-3.694 4.125-8.25 4.125s-8.25-1.847-8.25-4.125" />
                        </svg>
                    </x-slot:icon>
                    {{ __('Dashboard') }}
                </x-admin.side-link>
            </x-admin.side-group>
            <x-admin.side-group title="{{ __('Products') }}">
                <x-admin.side-link route="admin.brands" title="{{ __('Brands') }}" />
                <x-admin.side-link route="admin.categories" title="{{ __('Categories') }}" />
                <x-admin.side-link route="admin.products" title="{{ __('Products') }}" />
            </x-admin.side-group>
            <x-admin.side-group title="{{ __('Users') }}">
                <x-admin.side-link route="admin.users" title="{{ __('Users') }}" />
                <x-admin.side-link route="admin.logs" title="{{ __('Logs') }}" />
            </x-admin.side-group>
            <x-admin.side-group title="{{ __('Logout') }}">
                <x-admin.side-link route="logout" title="{{ __('Logout') }}">
                    <x-slot:icon>
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                  d="M8.25 9V5.25A2.25 2.25 0 0 1 10.5 3h6a2.25 2.25 0 0 1 2.25 2.25v13.5A2.25 2.25 0 0 1 16.5 21h-6a2.25 2.25 0 0 1-2.25-2.25V15m-3 0-3-3m0 0 3-3m-3 3H15" />
                        </svg>
                    </x-slot:icon>
                </x-admin.side-link>
            </x-admin.side-group>
        </div>

        <div class="absolute bottom-2 right-2">
            <div class="flex items-center justify-end gap-2">
                <button type="button" class="rounded-full bg-gray-200 p-2 text-gray-700 dark:text-gray-200 dark:bg-gray-800" x-on:click="darkMode = !darkMode">
                    <svg x-show="!darkMode" class="size-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"></path>
                    </svg>
                    <svg x-show="darkMode" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M12 3v2.25m6.364.386-1.591 1.591M21 12h-2.25m-.386 6.364-1.591-1.591M12 18.75V21m-4.773-4.227-1.591 1.591M5.25 12H3m4.227-4.773L5.636 5.636M15.75 12a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0Z" />
                    </svg>
                </button>
            </div>
        </div>
    </aside>
    <div class="ml-64 flex-1 transition-all duration-300">
        <main class="p-5">
            {{ $slot }}
        </main>
        <div id="modal"></div>
    </div>

    @livewireScripts
</body>

</html>
