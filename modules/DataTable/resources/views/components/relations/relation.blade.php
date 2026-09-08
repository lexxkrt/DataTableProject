@props(['field'])
<div class="relative border border-r-gray-400 p-4 dark:border-gray-500">
    <div class="absolute left-0 top-0 -translate-y-4 bg-gray-700 px-4">{{ $field->label }}</div>
    @isset($this->formRelations[$field->name])
        {{-- @dump($this->formRelations[$field->name]) --}}
        <div class="">
            <button type="button" class="rounded bg-blue-500 px-2 py-1 text-white" wire:click="addRelation('{{ $field->name }}')">{{ __('Add') }}</button>
        </div>
        <table>
            @foreach ($this->formRelations[$field->name] as $key => $row)
                <tr wire:key="{{ $field->name }}-{{ $key }}">
                    @foreach ($field->fields as $column)
                        <td class="p-1">
                            <x-dynamic-component :component="$column->view" :relation="$field->name" :key="$key" :column="$column" />
                        </td>
                    @endforeach
                    <td class="p-1">
                        <button type="button" class="rounded bg-red-500 px-2 py-1 text-white" wire:click="removeRelation('{{ $field->name }}', '{{ $key }}')">{{ __('Remove') }}</button>
                    </td>
                </tr>
            @endforeach
        </table>
    @endisset
</div>
