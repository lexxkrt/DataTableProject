@props(['field'])
@php
    $status = $this->formData[$field->name] ?? false;
@endphp
<div class="inline-flex items-center gap-2">
    <span class="">{{ __($field->label) }}</span>
    <label class="relative flex cursor-pointer items-center">
        <input wire:model.live="{{ $field->key }}" type="checkbox" class="peer sr-only">
        <div
             class="peer h-6 w-11 rounded-full bg-gray-200 transition-all duration-500 ease-in-out after:absolute after:left-0.5 after:top-0.5 after:h-5 after:w-5 after:rounded-full after:border after:border-gray-300 after:bg-white after:transition-all after:content-[''] hover:bg-gray-300 peer-checked:bg-indigo-600 peer-checked:after:translate-x-full peer-checked:after:border-white hover:peer-checked:bg-indigo-700 peer-focus:outline-0">
        </div>
        <span class="ml-2 hidden peer-checked:block">
            <span class="select-none rounded border border-emerald-300 bg-emerald-50 px-2 py-0.5 text-emerald-700">{{ __('Enabled') }}</span>
        </span>
        <span class="ml-2 block peer-checked:hidden">
            <span class="select-none rounded border border-amber-300 bg-amber-50 px-2 py-0.5 text-amber-700">{{ __('Disabled') }}</span>
        </span>
    </label>
</div>
