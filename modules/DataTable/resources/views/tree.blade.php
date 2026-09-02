@use('Illuminate\Pagination\LengthAwarePaginator')
<div class="data-table space-y-3">
    <div class="flex items-end justify-between">
        <h1>{{ __($this->getTitle()) }}</h1>
        <div class="flex items-center gap-2">
            @foreach ($this->bulkActions() as $action)
                <x-dynamic-component :component="$action->view" :$action />
            @endforeach
        </div>
    </div>
    <div class="flex items-end justify-between gap-3">
        <div class="flex items-center gap-3">
            @foreach ($this->filters() as $filter)
                <x-dynamic-component :component="$filter->view" :$filter />
            @endforeach
        </div>
        <div class="flex flex-1 justify-end">
            @php
                $searchable = collect($this->columns())->where('searchable', true)->isNotEmpty();
            @endphp
            @if ($searchable)
                <div class="inline-flex items-center gap-1">
                    <label for="search" class="">{{ __('Search') }}</label>
                    <input class="max-w-80" id="search" type="text" wire:model.live.debounce.300ms="search">
                </div>
            @endif
        </div>
    </div>
    <table class="">
        <thead class="">
            <tr class="">
                @foreach ($this->columns() as $column)
                    @php
                        $hidden = $column->hidden;
                        $align = match ($column->align) {
                            'left' => 'text-left justify-start',
                            'center' => 'text-center justify-center',
                            'right' => 'text-right justify-end',
                            default => $column->align,
                        };
                        $width = $column->width;
                    @endphp
                    <th @class(['hidden' => $hidden, $align, $width])>
                        @if ($column->sortable)
                            <span wire:click="sortBy('{{ $column->name }}')"
                                  class="{{ $align }} flex cursor-pointer items-center gap-1 opacity-75 hover:opacity-100">
                                {{ __($column->label) }}
                                @if ($this->sortField == $column->name)
                                    @if ($this->sortDirection == 'asc')
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 15.75 7.5-7.5 7.5 7.5" />
                                        </svg>
                                    @else
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" />
                                        </svg>
                                    @endif
                                @else
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 15 12 18.75 15.75 15m-7.5-6L12 5.25 15.75 9" />
                                    </svg>
                                @endif
                            </span>
                        @else
                            <span class="{{ $align }} flex items-center opacity-75">
                                {{ __($column->label) }}
                            </span>
                        @endif
                    </th>
                @endforeach
                <th class="w-20">{{ __('Actions') }}</th>
            </tr>
        </thead>
        <tbody class="">
            @forelse ($this->data as $row)
                <tr x-on:click="$wire.set('parent_id',{{ $row['category']->id }})">
                    @foreach ($this->columns() as $column)
                        @php
                            $hidden = $column->hidden;
                            $align = match ($column->align) {
                                'left' => 'text-left',
                                'center' => 'text-center',
                                'right' => 'text-right',
                                default => $column->align,
                            };
                            $width = $column->width;
                        @endphp
                        <td wire:key="{{ $row['category']->getTable() }}-{{ $column->name }}-{{ $row['category']->{$row['category']->getKeyName()} }}" @class(['hidden' => $hidden, $align, $width])>
                            <x-dynamic-component :component="$column->view" :$column :row="$row['category']" />
                        </td>
                    @endforeach
                    <td>
                        <div class="flex items-center gap-2">
                            @foreach ($this->actions() as $action)
                                <x-dynamic-component :component="$action->view" :$action :row="$row['category']" />
                            @endforeach
                        </div>
                    </td>
                </tr>
                {{-- @include('data-table::children', ['row' => $row]) --}}
            @empty
                <tr>
                    <td colspan="{{ count($this->columns()) }}">{{ __('No results found') }}</td>
                </tr>
            @endforelse
        </tbody>
    </table>
    @include('data-table::form')
</div>
