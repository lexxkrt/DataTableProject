@props(['field'])
@php
    $placeholder = $field->label;
    $required = str($field->rules)->contains('required');
@endphp

<div class="w-full">
    <div class="flex flex-col">
        <label @class([
            "after:content-['*'] after:text-red-500 after:mx-0.5" => $required,
        ])
               for="{{ $field->name }}">{{ __($field->label) }}</label>
        <textarea class=""
                  rows="{{ $field->rows }}"
                  id="{{ $field->name }}"
                  name="{{ $field->name }}"
                  wire:model="{{ $field->key }}"></textarea>
    </div>
    @error($field->key)
        <span class="text-sm text-red-500">{{ $message }}</span>
    @enderror
</div>
