<div class="data-table">
    <div class="mb-5 flex items-end justify-between gap-3">
        <div class="flex items-end gap-3">
            <h1>{{ __($this->title()) }}</h1>
            <div>bread/crumbs</div>
        </div>
        <div class="flex items-center justify-end gap-2">
            <button type="button" class="button" wire:click="create">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                </svg>
                Create</button>
        </div>
    </div>
    <div class="space-y-3">
        <div class="flex items-end justify-between gap-3">
            <div class=""></div>
            <div class="">
                <div class="relative inline-flex w-80 items-center gap-2">
                    <label for="">{{ __('Search') }}</label>
                    <input type="text" wire:model.live.debounce="search" class="pr-12!">
                    <span class="absolute right-1 top-1/2 -translate-y-1/2" wire:click="$wire.set('search','')">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                        </svg>
                    </span>
                </div>
            </div>
        </div>
        <table>
            <thead>
                <tr>
                    @foreach ($this->columns() as $column)
                        @php
                            $align = match ($column->align) {
                                'left' => 'text-start',
                                'center' => 'text-center',
                                'right' => 'text-right',
                                default => $column->align,
                            };
                        @endphp
                        <th @class([$align, $column->width, 'hidden' => $column->hidden])>
                            @if ($column->sortable)
                                <a wire:click="sortBy('{{ $column->name }}')" class="inline-flex items-center gap-1">
                                    @if ($column->name === $this->sortField)
                                        @if ($this->sortDirection === 'asc')
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" />
                                            </svg>
                                        @else
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 15.75 7.5-7.5 7.5 7.5" />
                                            </svg>
                                        @endif
                                    @else
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 15 12 18.75 15.75 15m-7.5-6L12 5.25 15.75 9" />
                                        </svg>
                                    @endif
                                    {{ __($column->label) }}
                                </a>
                            @else
                                <span class="inline-flex items-center">
                                    {{ __($column->label) }}
                                </span>
                            @endif
                        </th>
                    @endforeach
                    @if ($this->actions())
                        <th class="w-20">{{ __('Actions') }}</th>
                    @endif
                </tr>
            </thead>
            <tbody>
                @forelse ($this->data as $row)
                    <tr>
                        @foreach ($this->columns() as $column)
                            @php
                                $align = match ($column->align) {
                                    'left' => 'text-start',
                                    'center' => 'text-center',
                                    'right' => 'text-right',
                                    default => $column->align,
                                };
                            @endphp
                            <td @class([$align, $column->width, 'hidden' => $column->hidden])><x-dynamic-component :component="$column->view" :$column :$row /></td>
                        @endforeach
                        @if ($this->actions())
                            <td class="w-20">
                                <div class="inline-flex items-center gap-2">
                                    @foreach ($this->actions() as $action)
                                        <x-dynamic-component :component="$action->view" :$action :$row />
                                    @endforeach
                                </div>
                            </td>
                        @endif
                    </tr>
                @empty
                    <tr>
                        <td colspan="{{ count($this->columns()) + ($this->actions() ? 1 : 0) }}" class="text-center">{{ __('No data found') }}</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        @if ($this->data instanceof Illuminate\Pagination\LengthAwarePaginator)
            <div class="">
                {{ $this->data->links() }}
            </div>
        @endif
    </div>
</div>
