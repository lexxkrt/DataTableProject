@php
if (! isset($scrollTo)) {
    $scrollTo = 'body';
}

$scrollIntoViewJsSnippet = ($scrollTo !== false)
    ? <<<JS
       (\$el.closest('{$scrollTo}') || document.querySelector('{$scrollTo}')).scrollIntoView()
    JS
    : '';
@endphp

<div>
    @if ($paginator->hasPages())
        <nav role="navigation" aria-label="Pagination Navigation" class="navigation flex items-center justify-between">
            <div class="flex flex-1 flex-wrap items-center justify-between flex-col md:flex-row gap-y-3 gap-x-2">
                <div class="">
                    <p class="text-sm leading-5 text-gray-700 dark:text-gray-400">
                        <span>{!! __('Showing') !!}</span>
                        <span class="font-medium">{{ $paginator->firstItem() }}</span>
                        <span>{!! __('to') !!}</span>
                        <span class="font-medium">{{ $paginator->lastItem() }}</span>
                        <span>{!! __('of') !!}</span>
                        <span class="font-medium">{{ $paginator->total() }}</span>
                        <span>{!! __('results') !!}</span>
                    </p>
                </div>
                <div class="flex-1 text-center sm:text-right">
                    <div class="inline-flex items-center space-x-1">
                        <button type="button" 
                        class="flex! items-center justify-center h-8 min-w-8 border border-gray-400 rounded bg-gray-200 hover:bg-gray-300 px-1 disabled:bg-gray-100 disabled:text-gray-400 disabled:cursor-default! disabled:border-gray-200"
                        @disabled($paginator->onFirstPage()) 
                        wire:click="previousPage('{{ $paginator->getPageName() }}')" x-on:click="{{ $scrollIntoViewJsSnippet }}">
                            {{ __('Prev') }}
                        </button>
                        @foreach ($elements as $element)
                            @if (is_string($element))
                                <button type="button" 
                                    disabled
                                    class="md:flex items-center justify-center hidden border border-gray-400 rounded min-w-8 h-8 bg-gray-200 hover:bg-gray-300 disabled:bg-gray-100 disabled:font-bold disabled:cursor-default! disabled:border-gray-200"
                                    >
                                    {{ $element }}
                                </button>
                            @endif
                            @if (is_array($element))
                                @foreach ($element as $page => $url)
                                    <button type="button" class="md:flex items-center justify-center hidden border border-gray-400 rounded min-w-8 h-8 bg-gray-200 hover:bg-gray-300 disabled:bg-gray-100 disabled:font-bold disabled:cursor-default! disabled:border-gray-200"
                                            wire:click="gotoPage({{ $page }}, '{{ $paginator->getPageName() }}')"
                                            x-on:click="{{ $scrollIntoViewJsSnippet }}"
                                            @disabled($page == $paginator->currentPage())>
                                        {{ $page }}
                                    </button>
                                @endforeach
                            @endif
                        @endforeach
                        <button type="button" 
                            class="flex! items-center justify-center h-8 min-w-8 border border-gray-400 rounded bg-gray-200 hover:bg-gray-300 px-1 disabled:bg-gray-100 disabled:text-gray-400 disabled:cursor-default! disabled:border-gray-200"
                            @disabled(!$paginator->hasMorePages())
                            wire:click="nextPage('{{ $paginator->getPageName() }}')"
                            x-on:click="{{ $scrollIntoViewJsSnippet }}">
                            {{ __('Next') }}
                        </button>
                    </div>
                </div>
            </div>
        </nav>
    @endif
</div>
