@props(['action', 'row'])
@php
    $confirmMessage = __('Are you sure?');
@endphp

<a wire:click="rowAction('{{ $action->name }}', '{{ $row->getKey() }}')"
   @if ($action->confirm) wire:confirm='{{ $confirmMessage }}' @endif>
    {{ $action->label }}
</a>
