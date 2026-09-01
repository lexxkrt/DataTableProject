@props(['field'])
@php
    $class = match ($field->column) {
        2 => 'grid-cols-2',
        3 => 'grid-cols-3',
        4 => 'grid-cols-4',
        5 => 'grid-cols-5',
        6 => 'grid-cols-6',
        default => 'grid-cols-1',
    };
@endphp
<div @class([$class, $field->css, 'grid gap-3'])>
    @foreach ($field->fields as $item)
        <x-dynamic-component :component="$item->view" :field="$item" />
    @endforeach
</div>
