@props(['field'])

<div @class([
    $field->css,
    'flex flex-col gap-3',
    'border border-gray-400 dark:border-gray-500 p-3' => $field->bordered,
])>
    @foreach ($field->fields as $item)
        <x-dynamic-component :component="$item->view" :field="$item" />
    @endforeach
</div>
