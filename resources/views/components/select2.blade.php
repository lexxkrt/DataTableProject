<div class="relative" wire:ignore.self
     x-data="{opened:false}"
     x-init="$watch('opened',(value)=>{
     if(value){
        $nextTick(() => { $refs.search_{{ $name }}.focus(); console.log($refs.search_{{ $name }}) })
     }
     })"
     x-on:keydown.escape.window="opened=false"
     x-on:click.away="opened=false">
    <div class="p-2 w-full border border-gray-400 dark:border-gray-500 rounded-lg relative bg-white dark:bg-gray-700">
        <div class="pr-10" x-on:click="opened=!opened">
            @forelse ($selected[$this->name]??[] as $id=>$title)
                <span class="inline-flex items-center gap-1 px-1 leading-normal bg-gray-200 text-gray-700 rounded-lg">
                    <a x-on:click.stop="" wire:click="select('{{ $id }}','{{ $title }}')">
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
                    </a>
                    {{ $title }}
                </span>
            @empty
                <span class="px-1 leading-normal text-gray-400 dark:text-gray-500 rounded-lg">{{ __('Placeholder') }}</span>
            @endforelse
        </div>
        <input type="hidden"
               name="">
        <span class="absolute p-2 right-0 bottom-0"
              x-on:click="opened = !opened">
            <svg x-show="!opened"
                 xmlns="http://www.w3.org/2000/svg"
                 fill="none"
                 viewBox="0 0 24 24"
                 stroke-width="1.5"
                 stroke="currentColor"
                 class="size-6">
                <path stroke-linecap="round"
                      stroke-linejoin="round"
                      d="m19.5 8.25-7.5 7.5-7.5-7.5" />
            </svg>
            <svg x-show="opened"
                 xmlns="http://www.w3.org/2000/svg"
                 fill="none"
                 viewBox="0 0 24 24"
                 stroke-width="1.5"
                 stroke="currentColor"
                 class="size-6">
                <path stroke-linecap="round"
                      stroke-linejoin="round"
                      d="m4.5 15.75 7.5-7.5 7.5 7.5" />
            </svg>

        </span>
    </div>
    <div x-show="opened"
         class="p-2 border border-gray-400 dark:border-gray-500 rounded-lg absolute top-full left-0 right-0 z-10 dark:bg-gray-800 bg-gray-100 translate-y-px">
        <div class="flex items-center justify-between gap-1 relative">
            <input type="text"
                   name="{{ $name }}"
                   x-ref="search_{{ $name }}"
                   wire:model.live="search"
                   class="ps-2 pe-10 py-1 border border-gray-400 dark:border-gray-500 rounded-lg bg-white dark:bg-gray-700 w-full">
            <span class="absolute right-2 top-1/2 -translate-y-1/2"
                  x-on:click="$wire.set('search','')">
                <svg xmlns="http://www.w3.org/2000/svg"
                     fill="none"
                     viewBox="0 0 24 24"
                     stroke-width="1.5"
                     stroke="currentColor"
                     class="size-6">
                    <path stroke-linecap="round"
                          stroke-linejoin="round"
                          d="M6 18 18 6M6 6l12 12" />
                </svg>
            </span>
        </div>
        @if($results)
            <div class="overflow-y-auto max-h-40 px-2">
                <ul class="pt-2">
                    @foreach ($results as $id => $title)
                        @php
                            $exist = array_key_exists($id, $selected[$this->name]);
                        @endphp
                        <li wire:key="{{ $id }}">
                            <a @class([
                                'dark:hover:bg-white/10 even:dark:bg-white/5 cursor-pointer px-2 py-1 hover:bg-gray-200 flex items-center gap-1',
                                'dark:bg-white/10 bg-gray-200' => $exist,
                                'dark:text-green-200 text-green-700' => $exist
                            ])
                               wire:click="select('{{ $id }}','{{ $title }}')">
                                @if($exist)
                                    <span><svg xmlns="http://www.w3.org/2000/svg"
                                             fill="none"
                                             viewBox="0 0 24 24"
                                             stroke-width="1.5"
                                             stroke="currentColor"
                                             class="size-4">
                                            <path stroke-linecap="round"
                                                  stroke-linejoin="round"
                                                  d="m4.5 12.75 6 6 9-13.5" />
                                        </svg>
                                    </span>
                                @else
                                    <span class="size-4">
                                    </span>
                                @endif
                                {{ $title }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>
        @endif
    </div>
</div>
