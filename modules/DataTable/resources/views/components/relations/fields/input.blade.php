@props(['relation', 'key', 'column'])
@php
    $key = "formRelations.{$relation}.{$key}.{$column->name}";
@endphp
<div class="flex w-full flex-col items-start">
    <input wire:model="{{ $key }}"
           type="text" @class(['error' => $errors->has($key)])>
    @error($key)
        <span class="text-sm text-red-500 dark:text-red-50">{{ $message }}</span>
    @enderror
</div>
