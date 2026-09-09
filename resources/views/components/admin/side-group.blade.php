@props(['title' => ''])
@if ($title)
    <h2 class="mb-2 text-lg font-bold uppercase">{{ __($title) }}</h2>
@endif
<ul class="space-y-2 rounded-lg border border-gray-400 p-2 dark:border-gray-600">
    {{ $slot }}
</ul>
