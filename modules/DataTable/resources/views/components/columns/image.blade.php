@props(['column', 'row'])
@php
    $value = $row->{$column->name};
@endphp

<img @class([$column->size]) src="{{ $value }}" alt="">
