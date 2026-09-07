@props(['relation', 'key', 'column'])
<input wire:model="formRelations.{{ $relation }}.{{ $key }}.{{ $column->name }}"
       type="text" class="border border-gray-300 p-2">
