@props(['column', 'row'])
@php
    $image = $row->getImage();
    $value = value($column->value, $row) ?? $row->{$column->name};
    // $description = $row->slug;
@endphp
<div class="flex items-center gap-2">
    <div class="">
        <img class="size-10" src="{{ $image }}" alt="">
    </div>
    <div class="flex flex-col">
        <div class="">{{ $value }}</div>
        <div class="text-xs opacity-70">
            <div>{{ __('Slug') }}: {{ $row->slug }}</div>
        </div>
    </div>
</div>
