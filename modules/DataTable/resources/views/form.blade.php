<x-data-table::modal title="{{ $this->formTitle() }}" :formSize="$this->formSize">
    <form wire:submit="store">
        <div class="flex flex-col gap-3">
            @foreach ($this->fields() as $field)
                <x-dynamic-component :component="$field->view" :$field />
            @endforeach
        </div>
        <div class="mt-3 flex items-center justify-end gap-2">
            <button class="button" type="submit">{{ __('Save') }}</button>
            <button class="button secondary" type="button" x-on:click="$dispatch('formClose')">{{ __('Cancel') }}</button>
        </div>
    </form>
</x-data-table::modal>
