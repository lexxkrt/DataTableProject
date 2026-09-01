@props(['field'])
<div class="flex justify-between items-start gap-3">
    @foreach ($field->fields as $item)
        <x-dynamic-component :component="$item->view" :field="$item" />
    @endforeach
</div>
