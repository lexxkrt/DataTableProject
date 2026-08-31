@props(['column', 'row'])
@php
    $value = $row->{$column->name};
@endphp

{{ $value }}
