@props(['action', 'row'])

<a wire:click="rowAction('{{ $action->name }}', '{{ $row->getKey() }}')"
   @if ($action->confirm) wire:confirm='{{ __($action->confirmMessage) }}' @endif>
    {{ $action->label }}
</a>
