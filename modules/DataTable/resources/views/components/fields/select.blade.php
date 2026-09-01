@props(['field'])
<div class="w-full">
    <label for="{{ $field->name }}">{{ __($field->label) }}</label>
    <select name="{{ $field->name }}" id="{{ $field->name }}" wire:model="{{ $field->key }}">
        <option value=""></option>
        @foreach ($field->options as $value => $label)
            {{-- @dump($this->formData[$field->key] ?? null, $value) --}}
            @if ($this->formData[$field->key] = $value)
                <option value="{{ $value }}">{{ $label }}</option>
            @endif
        @endforeach
    </select>
</div>
