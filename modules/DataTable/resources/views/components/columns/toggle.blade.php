@props(['column', 'row'])
@php
    $value = value($column->value, $row) ?? $row->{$column->name};
    $align = match ($column->align) {
        'left' => 'text-left',
        'center' => 'text-center',
        'right' => 'text-right',
        default => $column->align,
    };
@endphp

<div @class([$align])>
    <span
          @if ($column->action instanceof \Closure) wire:click="columnAction('{{ $column->name }}','{{ $row->getKey() }}')" @endif
          @class([
              'cursor-pointer opacity-85 hover:opacity-100' => $column->action instanceof \Closure,
              'text-xs rounded-full px-2 py-1',
              $value
                  ? 'bg-green-200 text-green-700 border border-green-500 dark:bg-green-700 dark:text-green-50'
                  : 'bg-gray-200 text-gray-700 border border-gray-500 dark:bg-gray-700 dark:text-gray-50',
          ])>
        {{ $value ? __('Enabled') : __('Disabled') }}
    </span>
</div>
