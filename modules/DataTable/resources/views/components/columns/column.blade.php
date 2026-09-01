@props(['column', 'row'])
@php
    $value = value($column->value, $row) ?? $row->{$column->name};
@endphp

{{ $value }}
