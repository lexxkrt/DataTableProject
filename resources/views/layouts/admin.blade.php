<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>{{ $title ?? config('app.name') }}</title>

    @vite(['resources/css/admin.css', 'resources/js/app.js'])

    @livewireStyles
</head>

<body x-cloak
      x-data="{ darkMode: $persist(false) }"
      :class="darkMode && 'dark'">

    <aside class="fixed bottom-0 left-0 top-0 w-64 p-5 flex flex-col gap-5">
        <div class="">
            <div class="mb-6 border-b border-b-gray-400 dark:border-b-gray-600">
                <div class="inline-flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg"
                         fill="none"
                         viewBox="0 0 24 24"
                         stroke-width="1.5"
                         stroke="currentColor"
                         class="size-6">
                        <path stroke-linecap="round"
                              stroke-linejoin="round"
                              d="M14.25 9.75 16.5 12l-2.25 2.25m-4.5 0L7.5 12l2.25-2.25M6 20.25h12A2.25 2.25 0 0 0 20.25 18V6A2.25 2.25 0 0 0 18 3.75H6A2.25 2.25 0 0 0 3.75 6v12A2.25 2.25 0 0 0 6 20.25Z" />
                    </svg>
                    <span class="text-nowrap text-xl font-bold leading-4">
                        {{ __('Admin Panel') }}
                    </span>
                </div>
            </div>
            <div class="space-y-5">
                <x-admin.side-group title="{{ __('Dashboard') }}">
                    <x-admin.side-link route="admin.home"
                                       title="{{ __('Dashboard') }}">
                        <x-slot:icon>
                            <svg xmlns="http://www.w3.org/2000/svg"
                                 fill="none"
                                 viewBox="0 0 24 24"
                                 stroke-width="1.5"
                                 stroke="currentColor"
                                 class="size-6">
                                <path stroke-linecap="round"
                                      stroke-linejoin="round"
                                      d="M20.25 6.375c0 2.278-3.694 4.125-8.25 4.125S3.75 8.653 3.75 6.375m16.5 0c0-2.278-3.694-4.125-8.25-4.125S3.75 4.097 3.75 6.375m16.5 0v11.25c0 2.278-3.694 4.125-8.25 4.125s-8.25-1.847-8.25-4.125V6.375m16.5 0v3.75m-16.5-3.75v3.75m16.5 0v3.75C20.25 16.153 16.556 18 12 18s-8.25-1.847-8.25-4.125v-3.75m16.5 0c0 2.278-3.694 4.125-8.25 4.125s-8.25-1.847-8.25-4.125" />
                            </svg>
                        </x-slot:icon>
                        {{ __('Dashboard') }}
                    </x-admin.side-link>
                </x-admin.side-group>
                <x-admin.side-group title="{{ __('Products') }}">
                    <x-admin.side-link route="admin.brands"
                                       title="{{ __('Brands') }}" />
                    <x-admin.side-link route="admin.categories"
                                       title="{{ __('Categories') }}" />
                    <x-admin.side-link route="admin.products"
                                       title="{{ __('Products') }}" />
                </x-admin.side-group>
                <x-admin.side-group title="{{ __('Users') }}">
                    <x-admin.side-link route="admin.users"
                                       title="{{ __('Users') }}" />
                    <x-admin.side-link route="admin.logs"
                                       title="{{ __('Logs') }}" />
                </x-admin.side-group>
                <x-admin.side-group title="{{ __('Logout') }}">
                    <x-admin.side-link route="logout"
                                       title="{{ __('Logout') }}">
                        <x-slot:icon>
                            <svg xmlns="http://www.w3.org/2000/svg"
                                 fill="none"
                                 viewBox="0 0 24 24"
                                 stroke-width="1.5"
                                 stroke="currentColor"
                                 class="size-6">
                                <path stroke-linecap="round"
                                      stroke-linejoin="round"
                                      d="M8.25 9V5.25A2.25 2.25 0 0 1 10.5 3h6a2.25 2.25 0 0 1 2.25 2.25v13.5A2.25 2.25 0 0 1 16.5 21h-6a2.25 2.25 0 0 1-2.25-2.25V15m-3 0-3-3m0 0 3-3m-3 3H15" />
                            </svg>
                        </x-slot:icon>
                    </x-admin.side-link>
                </x-admin.side-group>
            </div>
        </div>
        <footer class="mt-auto relative py-2 flex items-center justify-center">
            <p>&copy; {{ date('Y') }} {{ config('app.name') }}</p>
            <div class="absolute bottom-0 right-0">
                <x-dark-mode-toggler />
            </div>
        </footer>
    </aside>
    <div class="ml-64 flex-1 transition-all duration-300 min-h-screen flex flex-col">
        <main class="p-5 grow">
            {{ $slot }}
        </main>
        <div id="modal"></div>
    </div>

    @livewireScripts
</body>

</html>