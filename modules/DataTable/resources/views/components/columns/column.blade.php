@props(['column', 'row'])
@php
    $value = value($column->value, $row);
    if (is_null($value)) {
        if (str_contains($column->name, '.')) {
            [$relation, $field] = explode('.', $column->name);
            $value = $row->{$relation}->{$field};
        } else {
            $value = $row->{$column->name};
        }
    }
    if (is_array($value)) {
        $value = json_encode($value, JSON_UNESCAPED_UNICODE);
        $value = str_replace('","', '", "', $value);
    }
@endphp

{{ $value }}
