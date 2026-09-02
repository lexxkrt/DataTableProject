@props(['row', 'level' => 1])
@dump($row)
{{-- <tr wire:key="{{ $row->getTable() }}-{{ $row->getKey() }}">
    @foreach ($this->columns() as $column)
        @php
            $hidden = $column->hidden;
            $align = match ($column->align) {
                'left' => 'text-left',
                'center' => 'text-center',
                'right' => 'text-right',
                default => $column->align,
            };
            $width = $column->width;
        @endphp
        <td wire:key="{{ $row->getTable() }}-{{ $column->name }}-{{ $row->{$row->getKeyName()} }}" @class(['hidden' => $hidden, $align, $width])>
            <x-dynamic-component :component="$column->view" :$column :$row />
        </td>
    @endforeach
    <td wire:key="{{ $row->getTable() }}-actions-{{ $row->getKey() }}">
        <div class="flex items-center gap-2">
            @foreach ($this->actions() as $action)
                <x-dynamic-component :component="$action->view" :$action :$row />
            @endforeach
        </div>
    </td>
</tr>
@if ($row->children)
    @foreach ($row->children as $child)
        @include('data-table::children', ['row' => $child, 'level' => $level + 1])
    @endforeach
@endif --}}
