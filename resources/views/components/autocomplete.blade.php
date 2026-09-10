<div x-data="{opened:false,search:@entangle('search'),results:[]}"
     x-on:click.away="opened=false"
     class="relative">
    <div class="relative">
        <div class="relative flex items-center gap-2">
            <label for="search">Search</label>
            <input type="text"
                   x-on:focus="opened=true"
                   class="bg-gray-700 border ps-2 py-1 pe-12 rounded-lg w-full"
                   wire:model.live="search"
                   name="search"
                   id="search">
            <span x-on:click="$wire.set('search','')"
                  class="absolute right-1">
                <svg xmlns="http://www.w3.org/2000/svg"
                     fill="none"
                     viewBox="0 0 24 24"
                     stroke-width="1.5"
                     stroke="currentColor"
                     class="size-4">
                    <path stroke-linecap="round"
                          stroke-linejoin="round"
                          d="M6 18 18 6M6 6l12 12" />
                </svg>
            </span>
            <div wire:loading
                 class="text-primary size-4 absolute right-6 top-1/2 -my-2 inline-block grow animate-spin rounded-full border-4 border-solid border-current border-e-transparent bg-white dark:bg-slate-700 align-[-0.125em] motion-reduce:animate-[spin_1.5s_linear_infinite">
            </div>
        </div>
    </div>
    @if (count($results) && $opened)
        <div x-show="opened"
             class="dark:bg-slate-900 dark:text-gray-300 dark:border-slate-700 absolute -right-2 left-2 top-full translate-y-1 border border-slate-300 bg-white p-2 text-sm text-gray-700 shadow-lg z-10">
            <ul>
                @foreach ($results as $id => $name)
                    <li wire:key="{{ $id }}">
                        <a class="dark:hover:bg-slate-800 block cursor-pointer px-2 hover:bg-gray-200"
                           wire:click="select('{{ $id }}','{{ $name }}')">{{ $name }}</a>
                    </li>
                @endforeach
            </ul>
        </div>
    @endif
</div>