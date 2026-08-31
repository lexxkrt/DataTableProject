@props(['filter'])
<select wire:model="filters.{{ $filter->name }}" name="filter-{{ $Filter->name }}" id="Filter-{{ $filter->name }}">
    <option value="">{{ __('All') }}</option>
    @foreach ($filter->options as $value => $label)
        <option value="{{ $value }}">{{ $label }}</option>
    @endforeach
</select>
