@props(['field'])
@php
    $placeholder = $field->label;
    $width = value($field->width) ?? 'w-full';
    $required = str($field->rules)->contains('required');
    $type = $field->type;
@endphp

<div @class([$width])>
    <label @class(['required' => $required]) for="field-{{ $field->name }}">{{ __($field->label) }}</label>
    <input @class(['error' => $errors->has($field->key)])
           type="{{ $type }}"
           id="field-{{ $field->name }}"
           name="field-{{ $field->name }}"
           placeholder="{{ __($placeholder) }}..."
           wire:model="{{ $field->key }}">
    @error($field->key)
        <span class="text-sm text-red-500">{{ $message }}</span>
    @enderror
</div>
