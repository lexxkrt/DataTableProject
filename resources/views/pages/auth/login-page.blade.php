<div class="flex min-h-screen items-center justify-center">
    <div class="mx-auto flex w-full max-w-xl gap-5 rounded-lg border border-gray-400 bg-gray-200 shadow-md dark:border-gray-600 dark:bg-gray-700">
        <div class="flex w-1/2 shrink-0 items-center justify-center bg-amber-700">
            <span class="">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="size-48" viewBox="0 0 16 16">
                    <path
                          d="M7.293 1.5a1 1 0 0 1 1.414 0L11 3.793V2.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v3.293l2.354 2.353a.5.5 0 0 1-.708.708L8 2.207l-5 5V13.5a.5.5 0 0 0 .5.5h4a.5.5 0 0 1 0 1h-4A1.5 1.5 0 0 1 2 13.5V8.207l-.646.647a.5.5 0 1 1-.708-.708z" />
                    <path d="M10 13a1 1 0 0 1 1-1v-1a2 2 0 0 1 4 0v1a1 1 0 0 1 1 1v2a1 1 0 0 1-1 1h-4a1 1 0 0 1-1-1zm3-3a1 1 0 0 0-1 1v1h2v-1a1 1 0 0 0-1-1" />
                </svg>
            </span>
        </div>
        <div class="grow py-10 pe-10 ps-5">
            <h1 class="mb-5 text-2xl font-bold">{{ __('Login') }}</h1>
            @if ($errors->has('email'))
                <div class="mb-5 flex flex-col gap-6 border border-red-300 bg-red-100 p-3 dark:border-red-400 dark:bg-red-900">
                    <span class="text-sm text-red-500 dark:text-red-300">{{ $errors->first('email') }}</span>
                </div>
            @endif
            <form wire:submit="login" class="flex flex-col gap-6">
                <div class="space-y-1">
                    <label for="email" class="flex flex-col gap-2">{{ __('E-mail') }}</label>
                    <input class=""
                           autocomplete="new-email"
                           type="email" id="email" name="email"
                           placeholder="{{ __('E-mail') }}" wire:model="email">
                </div>
                <div class="space-y-1">
                    <label for="password" class="flex flex-col gap-2">{{ __('Password') }}</label>
                    <input class=""
                           autocomplete="new-password"
                           type="password" id="password" name="password"
                           placeholder="{{ __('Password') }}" wire:model="password">
                </div>
                <div class="space-y-1">
                    <label for="remember" class="flex items-center gap-2">
                        <input type="checkbox" name="remember" wire:model="remember">
                        {{ __('Remember me') }}
                    </label>
                </div>
                <button type="submit">Login</button>
            </form>
        </div>
    </div>
</div>
