@props(['column', 'row'])
@php
    $img = $row->image ?? asset('images/no_img.jpg');
    $value = value($column->value, $row) ?? $row->{$column->field};
    $description = $row->slug;
@endphp
<x-data-table::columns.column>
    <div class="flex items-center gap-2">
        <div class="">
            <img class="size-10" src="{{ $img }}" alt="">
        </div>
        <div class="flex flex-col">
            <div class="">{{ $value }}</div>
            <div class="text-xs opacity-70">{{ $description }}</div>
        </div>
    </div>

</x-data-table::columns.column>
