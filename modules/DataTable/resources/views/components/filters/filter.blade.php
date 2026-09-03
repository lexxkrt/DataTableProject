@props(['filter'])
<div class="inline-flex items-center gap-2 transition-colors duration-500">
    <label for="filter-{{ $filter->name }}" class="text-nowrap">{{ __($filter->label) }}</label>
    <select class="max-w-52" wire:model.live="filters.{{ $filter->name }}" name="filter-{{ $filter->name }}" id="filter-{{ $filter->name }}">
        <option value="">{{ __('All') }}</option>
        @foreach ($filter->options as $value => $label)
            <option value="{{ $value }}">{!! __($label) !!}</option>
        @endforeach
    </select>
</div>
