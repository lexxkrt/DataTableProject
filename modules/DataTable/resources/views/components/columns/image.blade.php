@props(['column', 'row'])
@php
    $image = $row->getImage('small') ?? asset('images/no_img.jpg');
    $preview = $row->getImage('original');
    $size = $column->size ?: 'size-10';
@endphp
<div class="flex items-center justify-center">
    <div @class([
        'flex items-center justify-center overflow-hidden bg-white',
        'cursor-pointer' => $preview,
    ])
         @if ($preview) x-on:click="$dispatch('preview', { image: '{{ $preview }}' })" @endif>
        <img src="{{ $image }}" alt="" @class([$size])>
    </div>
</div>

@once
    <div x-data="{ show: false }"
         x-show="show"
         x-trap.noscroll="show"
         x-on:keydown.escape.window="$dispatch('close')"
         x-on:close="show=false;$refs.previewImage.src=''"
         x-on:preview.window="$refs.previewImage.src=$event.detail.image;show=true"
         x-cloak>
        <div class="fixed inset-0 z-40 bg-black/30 backdrop-blur" x-on:click="$dispatch('close')"></div>
        <div class="fixed inset-0 z-40 m-auto flex w-full max-w-fit items-center justify-center p-10 text-gray-700">
            <div x-on:click.outside="$dispatch('close')"
                 class="relative flex max-h-[-webkit-fill-available] items-center justify-center overflow-hidden rounded-lg bg-white p-6 shadow-lg">
                <span class="absolute right-0 top-0 cursor-pointer rounded-full p-2 hover:bg-gray-100" x-on:click="$dispatch('close')">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                    </svg>
                </span>
                <img class="max-h-[-webkit-fill-available] object-contain" x-ref="previewImage" alt="">
            </div>
        </div>
    </div>
@endonce
