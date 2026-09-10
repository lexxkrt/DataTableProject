@props(['type'])
@php
    $class = match ($type) {
        'error' => 'border-red-300 bg-red-100 dark:border-red-400 dark:bg-red-900 text-red-500 dark:text-red-300',
        default => 'border-gray-300 bg-gray-100 dark:border-gray-600 dark:bg-gray-700 text-gray-500 dark:text-gray-300',
    }
@endphp
<div class="mb-5 flex flex-col gap-6 border p-3 {{ $class }}">
    <span class="text-sm">{{ $slot }}</span>
</div>