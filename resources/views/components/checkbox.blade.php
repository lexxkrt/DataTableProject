@props(['name', 'label' => ''])
@php
    empty($label) and $label = str($name)->replace(['-', '_'], ' ')->title()->value();
@endphp
<div class="space-y-1">
    <label for="{{ $name }}"
           class="flex items-center gap-2">
        <input type="checkbox"
               id="{{ $name }}"
               name="{{ $name }}"
               {{ $attributes }}>
        {{ __($label) }}
    </label>
</div>