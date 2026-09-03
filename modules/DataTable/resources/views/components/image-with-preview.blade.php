@props(['image', 'preview' => null])

@php
    $preview === true and ($preview = $image);
    empty($image) and $image = asset('images/no_img.jpg');
@endphp

@if ($preview)
    <span class="cursor-pointer" x-on:click="$dispatch('preview',{image:'{{ $preview }}'})">
        <img {{ $attributes }} src="{{ $image }}" alt="">
    </span>
@else
    <img {{ $attributes }} src="{{ $image }}" alt="">
@endif

@once
    <div x-data="{ show: false }"
         x-show="show"
         class="z-40"
         x-trap.noscroll="show"
         x-on:keydown.escape.window="$dispatch('close')"
         x-on:close="show=false"
         x-on:preview.window="$refs.previewImage.src=$event.detail.image;show=true"
         x-cloak>
        <div class="fixed inset-0 z-40 bg-black/30 backdrop-blur" x-on:click="$dispatch('close')"></div>
        <div class="fixed inset-0 z-40 m-auto flex w-full max-w-fit items-center justify-center p-10">
            <span class="absolute right-10 top-10 cursor-pointer rounded-full p-2 hover:bg-gray-100 dark:hover:bg-slate-900/50" x-on:click="$dispatch('close')">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                </svg>
            </span>
            <div x-on:click.outside="$dispatch('close')" class="block h-full max-h-full overflow-hidden rounded-lg bg-white p-6 shadow-lg dark:bg-slate-800">
                <img class="h-full object-fill" x-ref="previewImage" alt="">
            </div>
        </div>
    </div>
@endonce
