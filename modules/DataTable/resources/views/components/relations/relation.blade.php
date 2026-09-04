@props(['field'])
<div class="relative border border-r-gray-400 p-4 dark:border-gray-500">
    <div class="absolute left-0 top-0 -translate-y-4 bg-gray-700 px-4">{{ $field->label }}</div>
    @isset($this->formRelations[$field->name])
        <div class="">
            <button type="button" class="bg-blue-500 px-4 py-2 text-white" wire:click="addRelation('{{ $field->name }}')">Add</button>
        </div>
        @foreach ($this->formRelations[$field->name] as $key => $row)
            <div wire:key="{{ $field->name }}-{{ $key }}" class="flex gap-2">
                @foreach ($field->fields as $column)
                    <input wire:model="formRelations.{{ $field->name }}.{{ $key }}.{{ $column }}"
                           type="text" class="border border-gray-300 p-2">
                    {{-- <div class="hidden">{{ $row[$column] }}</div> --}}
                @endforeach
                <button type="button" class="bg-red-500 px-4 py-2 text-white" wire:click="removeRelation('{{ $field->name }}', '{{ $key }}')">Remove</button>
            </div>
        @endforeach
    @endisset
</div>
