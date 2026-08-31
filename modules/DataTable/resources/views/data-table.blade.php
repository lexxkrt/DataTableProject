<div class="data-table">
    <div class="">
        <div class="">
            <h1>{{ __($this->title()) }}</h1>
            <div>bread/crumbs</div>
        </div>
        <div class="">Command</div>
    </div>
    <div class="space-y-3">
        <div class="flex items-end justify-between gap-3">
            <div class=""></div>
            <div class="w-full">
                <div class="inline-flex w-80 items-center gap-2">
                    <label for="">search</label>
                    <input type="text" name="" id="" class="w-full">
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
                        <th @class([$align, $column->width, 'hidden' => $column->hidden])>{{ __($column->label) }}</th>
                    @endforeach
                    @if ($this->actions())
                        <th class="w-20">{{ __('Actions') }}</th>
                    @endif
                </tr>
            </thead>
            <tbody>
                @foreach ($this->data as $row)
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
                @endforeach
            </tbody>
        </table>
        @if ($this->data instanceof Illuminate\Pagination\LengthAwarePaginator)
            <div class="">
                {{ $this->data->links() }}
            </div>
        @endif
    </div>
</div>
