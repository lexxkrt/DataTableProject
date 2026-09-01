@props(['field'])
@php
    $placeholder = $field->placeholder ?: asset('images/no_img.jpg');
    $src = $this->formImageUrl($field->name) ?? $placeholder;
@endphp
<div class="relative w-36 flex flex-col items-center gap-3">
    <div class="flex size-32 items-center justify-center bg-white">
        <img class="max-h-full" x-ref="{{ $field->name }}" src="{{ $src }}" alt="">
    </div>
    <div class="flex items-center justify-center gap-1">
        <label for="{{ $field->name }}" class="cursor-pointer rounded bg-blue-500 p-2 text-white opacity-75 shadow hover:opacity-100">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5m-13.5-9L12 3m0 0 4.5 4.5M12 3v13.5" />
            </svg>
        </label>
        <span class="cursor-pointer rounded bg-red-500 p-2 text-white opacity-75 hover:opacity-100"
              x-on:click="$wire.formImageRemove('{{ $field->name }}'); $refs.{{ $field->name }}.src='{{ $placeholder }}';">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4">
                <path stroke-linecap="round" stroke-linejoin="round"
                      d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
            </svg>
        </span>
    </div>

    <input wire:model="formUploads.{{ $field->name }}" class="hidden" type="file" name="{{ $field->name }}" id="{{ $field->name }}">

    <div wire:loading wire:target="formUploads.{{ $field->name }}" class="absolute inset-0">
        <div class="absolute inset-0 animate-pulse bg-black/20"></div>
        <div class="absolute left-1/2 top-1/2 -ml-12 -mt-12">
            <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="h-24 w-24 animate-spin">
                <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                <g id="SVGRepo_iconCarrier">
                    <path
                          opacity="0.2"
                          fill-rule="evenodd"
                          clip-rule="evenodd"
                          d="M12 19C15.866 19 19 15.866 19 12C19 8.13401 15.866 5 12 5C8.13401 5 5 8.13401 5 12C5 15.866 8.13401 19 12 19ZM12 22C17.5228 22 22 17.5228 22 12C22 6.47715 17.5228 2 12 2C6.47715 2 2 6.47715 2 12C2 17.5228 6.47715 22 12 22Z"
                          fill="#000000"></path>
                    <path d="M12 22C17.5228 22 22 17.5228 22 12H19C19 15.866 15.866 19 12 19V22Z" fill="#000000"></path>
                    <path d="M2 12C2 6.47715 6.47715 2 12 2V5C8.13401 5 5 8.13401 5 12H2Z" fill="#000000"></path>
                </g>
            </svg>
        </div>
    </div>

    @error($field->key)
        <span class="text-red-500">{{ $message }}</span>
    @enderror
</div>
