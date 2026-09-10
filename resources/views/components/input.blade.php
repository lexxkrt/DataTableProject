@props(['name', 'label' => '', 'placeholder' => '', 'type' => 'text'])
@php
    empty($label) and $label = str($name)->replace(['-', '_'], ' ')->title()->value();
    empty($placeholder) and $placeholder = $label;
@endphp
<div class="space-y-1">
    <label for="{{ $name }}"
           class="flex flex-col gap-2">{{ __($label) }}</label>
    <input autocomplete="new-{{ $name }}"
           @class(['border-red-500! focus:ring-red-500! focus:border-red-500!' => $errors->has($name)])
           type="{{ $type }}"
           id="{{ $name }}"
           name="{{ $name }}"
           placeholder="{{ __($placeholder) . '...' }}"
           {{ $attributes }}>
    @error($name)
        <x-message type="error">{{ $message }}</x-message>
    @enderror
</div>