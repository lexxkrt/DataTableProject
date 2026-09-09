@props(['relation', 'key', 'column'])
@php
    $key = "formRelations.{$relation}.{$key}.{$column->name}";
@endphp
<div class="flex flex-col items-start">
    <select wire:model="{{ $key }}"
            @class(['error' => $errors->has($key)])>
        <option value="">{{ __('Select') }}</option>
        @foreach ($column->options as $value => $label)
            <option value="{{ $value }}">{{ $label }}</option>
        @endforeach
    </select>
    @error($key)
        <span class="text-sm text-red-500 dark:text-red-50">{{ $message }}</span>
    @enderror
</div>
