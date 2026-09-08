@props(['relation', 'key', 'column'])
<select wire:model="formRelations.{{ $relation }}.{{ $key }}.{{ $column->name }}"
        class="border border-gray-300 p-2">
    <option value="">{{ __('Select') }}</option>
    @foreach ($column->options as $value => $label)
        <option value="{{ $value }}">{{ $label }}</option>
    @endforeach
</select>
