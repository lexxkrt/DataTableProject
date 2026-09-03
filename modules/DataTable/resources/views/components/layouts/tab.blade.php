@props(['field'])
<div x-data="{ tab: '{{ $field->tabs[0]->name }}' }" x-init="$watch('show', value => { tab = value ? '{{ $field->tabs[0]->name }}' : '' })">
    {{-- header --}}
    <div class="flex gap-1">
        @foreach ($field->tabs as $tab)
            <a :key="{{ $tab->name }}"
               class = "translate-y-px select-none rounded-t border border-gray-400 bg-gray-200 px-3 py-2 font-bold text-gray-700 hover:bg-gray-200/50 hover:no-underline dark:border-gray-500 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-800/50"
               :class="{ 'border-b-transparent! dark:bg-gray-700! bg-gray-300!': tab == '{{ $tab->name }}' }"
               x-on:click="tab='{{ $tab->name }}'">{{ __($tab->label) }}</a>
        @endforeach
    </div>
    {{-- tab --}}
    <div class="border border-gray-400 p-4 dark:border-gray-500">
        @foreach ($field->tabs as $tab)
            <div x-cloak x-show="tab=='{{ $tab->name }}'" class="">
                @foreach ($tab->fields as $element)
                    <x-dynamic-component :component="$element->view"
                                         :field="$element" />
                @endforeach
            </div>
        @endforeach
    </div>
</div>
