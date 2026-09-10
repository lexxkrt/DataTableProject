@props(['title' => ''])
@if ($title)
    <h2 class="mb-2 text-lg font-bold uppercase border-b-2 border-b-gray-400 dark:border-b-gray-600">{{ __($title) }}
    </h2>
@endif
<ul class="space-y-2 p-2">
    {{ $slot }}
</ul>