<div class="flex min-h-screen items-center justify-center">
    <div
         class="mx-auto flex w-full max-w-xl gap-5 rounded-lg border border-gray-400 bg-gray-200 shadow-md dark:border-gray-600 dark:bg-gray-700">
        <div class="flex w-1/2 shrink-0 items-center justify-center bg-amber-700">
            <span class="">
                <svg xmlns="http://www.w3.org/2000/svg"
                     width="16"
                     height="16"
                     fill="currentColor"
                     class="size-48"
                     viewBox="0 0 16 16">
                    <path
                          d="M7.293 1.5a1 1 0 0 1 1.414 0L11 3.793V2.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v3.293l2.354 2.353a.5.5 0 0 1-.708.708L8 2.207l-5 5V13.5a.5.5 0 0 0 .5.5h4a.5.5 0 0 1 0 1h-4A1.5 1.5 0 0 1 2 13.5V8.207l-.646.647a.5.5 0 1 1-.708-.708z" />
                    <path
                          d="M10 13a1 1 0 0 1 1-1v-1a2 2 0 0 1 4 0v1a1 1 0 0 1 1 1v2a1 1 0 0 1-1 1h-4a1 1 0 0 1-1-1zm3-3a1 1 0 0 0-1 1v1h2v-1a1 1 0 0 0-1-1" />
                </svg>
            </span>
        </div>
        <div class="grow py-10 pe-10 ps-5">
            <h1 class="mb-5 text-2xl font-bold">{{ __('Login') }}</h1>
            {{-- @if ($errors->has('email'))
                <x-message type="error">{{ $errors->first('email') }}</x-message>
            @endif --}}
            <form wire:submit="login"
                  class="flex flex-col gap-6">
                <x-input name="email"
                         type="email"
                         wire:model="email" />
                <x-input name="password"
                         type="password"
                         wire:model="password" />
                <x-checkbox name="remember"
                            wire:model="remember" />
                <x-button type="submit">{{__('Login')}}</x-button>
            </form>
        </div>
    </div>
</div>